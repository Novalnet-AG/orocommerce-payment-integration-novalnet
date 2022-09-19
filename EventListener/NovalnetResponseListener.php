<?php

namespace Novalnet\Bundle\NovalnetBundle\EventListener;

use Oro\Bundle\PaymentBundle\Event\AbstractCallbackEvent;
use Oro\Bundle\PaymentBundle\Method\Provider\PaymentMethodProviderInterface;
use Psr\Log\LoggerAwareTrait;
use Oro\Bundle\EntityBundle\ORM\DoctrineHelper;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetHelper;
use Symfony\Contracts\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetCallback;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetPaymentMethod;
use Novalnet\Bundle\NovalnetBundle\Client\GatewayInterface;
use Oro\Bundle\FrontendLocalizationBundle\Manager\UserLocalizationManagerInterface;

/**
 * Listener handles response from novalnet server
 */
class NovalnetResponseListener
{
    use LoggerAwareTrait;

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @var PaymentMethodProviderInterface
     */
    protected $paymentProvider;

    /**
     * @var DoctrineHelper
     */
    private $doctrineHelper;

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var NovalnetCallback
     */
    protected $novalnetCallback;


    /**
     * @var GatewayInterface
     */
    protected $client;


    /**
     * @var UserLocalizationManager
     */
    protected $userLocalizationManager;

    /**
     * @param PaymentMethodProviderInterface $paymentProvider
     * @param DoctrineHelper $doctrineHelper
     * @param TranslatorInterface $translator
     * @param Session $session
     * @param NovalnetHelper $novalnetHelper
     * @param RouterInterface $routerInterface
     * @param NovalnetCallback $novalnetCallback
     * @param GatewayInterface $client
     * @param UserLocalizationManagerInterface $userLocalizationManager
     */
    public function __construct(
        PaymentMethodProviderInterface $paymentProvider,
        DoctrineHelper $doctrineHelper,
        TranslatorInterface $translator,
        Session $session,
        NovalnetHelper $novalnetHelper,
        RouterInterface $routerInterface,
        NovalnetCallback $novalnetCallback,
        GatewayInterface $client,
        UserLocalizationManagerInterface $userLocalizationManager
    ) {
        $this->paymentProvider = $paymentProvider;
        $this->doctrineHelper = $doctrineHelper;
        $this->translator = $translator;
        $this->session = $session;
        $this->novalnetHelper = $novalnetHelper;
        $this->router = $routerInterface;
        $this->novalnetCallback = $novalnetCallback;
        $this->client = $client;
        $this->userLocalizationManager = $userLocalizationManager;
    }

    /**
     * @param AbstractCallbackEvent $event
     * @return null
     */
    public function onError(AbstractCallbackEvent $event)
    {
        $paymentTransaction = $event->getPaymentTransaction();
        $responseData = $paymentTransaction->getResponse();

        if (!$paymentTransaction) {
            return;
        }
        if (false === $this->paymentProvider->hasPaymentMethod($paymentTransaction->getPaymentMethod())) {
            return;
        }

        # Handle direct payment failure transaction
        if (!empty($responseData) && $responseData['result']['status_code'] != '100') {
            $errorMsg = $responseData['result']['status_text'];
        } else {
			$eventData = $event->getData();
            $paymentMethod = $this->paymentProvider->getPaymentMethod($paymentTransaction->getPaymentMethod());
            $paymentAccessKey = $paymentMethod->config->getPaymentAccessKey();

            $novalnetTxnSecret = $paymentTransaction->getReference();
            $tokenString = $eventData['tid'] . $novalnetTxnSecret . $eventData['status'] . strrev($paymentAccessKey);
            $generatedChecksum = hash('sha256', $tokenString);
            $errorMsg = $generatedChecksum !== $eventData['checksum'] ?
                            $this->translator->trans('novalnet.hash_check_failed') : $eventData['status_text'];
        }
        $this->session->getFlashBag()->set('error', $errorMsg);
    }

    /**
     * @param AbstractCallbackEvent $event
     * @return null
     */
    public function onReturn(AbstractCallbackEvent $event)
    {
		
        $paymentTransaction = $event->getPaymentTransaction();
        if (!$paymentTransaction) {
            return;
        }

        $paymentMethodId = $paymentTransaction->getPaymentMethod();
        if (false === $this->paymentProvider->hasPaymentMethod($paymentMethodId)) {
            return;
        }
        $eventData = $event->getData();

        $transactionOptions = $paymentTransaction->getTransactionOptions();



        $paymentMethod = $this->paymentProvider->getPaymentMethod($paymentTransaction->getPaymentMethod());
        $paymentAccessKey = $paymentMethod->config->getPaymentAccessKey();

        //Validate the hash value from the Novalnet server for redirection payments
        $novalnetTxnSecret = $paymentTransaction->getReference();

        $tokenString = $eventData['tid'] . $novalnetTxnSecret . $eventData['status'] . strrev($paymentAccessKey);
        $generatedChecksum = hash('sha256', $tokenString);
        if ($generatedChecksum !== $eventData['checksum'] || $eventData['status_code'] != '100') {
			$errorMsg = ($generatedChecksum !== $eventData['checksum']) 
						? $this->translator->trans('novalnet.hash_check_failed') : $eventData['status_text'];
            $this->session->getFlashBag()->set('error', $errorMsg);
            $event->markFailed();
            $urlParams = ['id' => $transactionOptions['checkoutId'], 'transition' => 'payment_error'];
            $url = $this->router->generate('oro_checkout_frontend_checkout', $urlParams);
            $event->setResponse(new RedirectResponse($url));
            return;
        }

        $data = [];
        $data['transaction'] = [
            'tid' => $eventData['tid']
        ];

        $order = $this->doctrineHelper->getEntity(
            $paymentTransaction->getEntityClass(),
            $paymentTransaction->getEntityIdentifier()
        );

        $lang = $this->userLocalizationManager->getCurrentLocalizationByCustomerUser($order->getCustomerUser())
                                ->getLanguage()->getCode();

        $data['custom'] = [
            'lang' => strtoupper($lang),
        ];

        $response = $this->client->send($paymentAccessKey, $data, 'https://payport.novalnet.de/v2/transaction/details');

        $this->novalnetHelper->completeNovalnetOrder(
            $response,
            $paymentTransaction,
            $this->translator,
            $this->doctrineHelper
        );

        
		// set payment status
        try {
            if (in_array($response['transaction']['status'], ['PENDING', 'ON_HOLD'])) {
                $paymentMethod->execute(NovalnetPaymentMethod::PENDING, $paymentTransaction);
            } else {
                $paymentMethod->execute(NovalnetPaymentMethod::COMPLETE, $paymentTransaction);
            }
        } catch (\InvalidArgumentException $e) {
            if ($this->logger) {
                $this->logger->error($e->getMessage(), []);
            }
        }
    }

    /**
     * @param AbstractCallbackEvent $event
     * @return null
     */
    public function onNotify(AbstractCallbackEvent $event)
    {
        $paymentTransaction = $event->getPaymentTransaction();


        if (!$paymentTransaction) {
            return;
        }

        $paymentMethodId = $paymentTransaction->getPaymentMethod();

        if (false === $this->paymentProvider->hasPaymentMethod($paymentMethodId)) {
            return;
        }

        $this->novalnetCallback->startProcess($event, $this->paymentProvider);

        $event->markSuccessful();
    }
}
