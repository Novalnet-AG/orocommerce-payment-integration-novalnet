<?php

namespace Novalnet\Bundle\NovalnetBundle\EventListener;

use Oro\Bundle\PaymentBundle\Event\AbstractCallbackEvent;
use Oro\Bundle\PaymentBundle\Method\Provider\PaymentMethodProviderInterface;
use Psr\Log\LoggerAwareTrait;
use Oro\Bundle\EntityBundle\ORM\DoctrineHelper;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetHelper;
use Symfony\Component\Translation\TranslatorInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetCallback;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetPaymentMethod;

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
     * @var Router
     */
    protected $router;

    /** @var Session */
    protected $session;

    /** @var NovalnetCallback */
    protected $novalnetCallback;

    /**
     * @param PaymentMethodProviderInterface $paymentProvider
     * @param DoctrineHelper $doctrineHelper
     * @param TranslatorInterface $translator
     * @param Session $session
     * @param NovalnetHelper $novalnetHelper
     * @param RouterInterface $routerInterface
     * @param NovalnetCallback $novalnetCallback
     */
    public function __construct(
        PaymentMethodProviderInterface $paymentProvider,
        DoctrineHelper $doctrineHelper,
        TranslatorInterface $translator,
        Session $session,
        NovalnetHelper $novalnetHelper,
        RouterInterface $routerInterface,
        NovalnetCallback $novalnetCallback
    ) {
        $this->paymentProvider = $paymentProvider;
        $this->doctrineHelper = $doctrineHelper;
        $this->translator = $translator;
        $this->session = $session;
        $this->novalnetHelper = $novalnetHelper;
        $this->router = $routerInterface;
        $this->novalnetCallback = $novalnetCallback;
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
        $eventData = $event->getData();
        
        $paymentMethod = $this->paymentProvider->getPaymentMethod($paymentTransaction->getPaymentMethod());
        $paymentAccessKey = $paymentMethod->config->getPaymentAccessKey();
        
        $paymentTransaction
            ->setSuccessful(false)
            ->setActive(false);
        

        // saves transaction details
        if (isset($eventData['tid'])) {         
            $eventData['final_testmode'] = is_numeric($eventData['test_mode'])
            ? $eventData['test_mode']
            : ($this->novalnetHelper->decodeParams(
                $eventData['test_mode'],
                $paymentAccessKey,
                $eventData['uniqid']
            ));
            $this->novalnetHelper->insertNovalnetTransactionTable($this->doctrineHelper, $eventData, $paymentAccessKey);
            $paymentTransaction->setReference($eventData['tid']);
        }

        if(isset($responseData['status_desc']) || isset($responseData['status_text']))
        {
            $eventData['status_desc'] = ($responseData['status_desc']) ? $responseData['status_desc'] : $responseData['status_text'];
            $errorMsg = $eventData['status_desc'];
        }
        else {
            $errorMsg = !empty($eventData['status_desc']) ? $eventData['status_desc'] : (isset($eventData['status_text']) ? $eventData['status_text'] : '');
        }
        
        $this->novalnetHelper->setPaymentComments(
                $paymentTransaction,
                $this->doctrineHelper,
                $this->translator,
                $eventData,
                true
            );
        $errorMsg = !empty($eventData['status_desc']) ? $eventData['status_desc'] : $eventData['status_text'];
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
        if (isset($eventData['hash2'])) {
            $currentHash = $this->novalnetHelper->generateHash($eventData, $paymentAccessKey);
            if (($eventData['hash2'] != $currentHash)) {
                $errorMsg = $this->translator->trans('novalnet.hash_check_failed');
                $this->session->getFlashBag()->set('error', $errorMsg);
                $event->markFailed();
                $urlParams = ['id' => $transactionOptions['checkoutId'], 'transition' => 'payment_error'];
                $url = $this->router->generate('oro_checkout_frontend_checkout', $urlParams);
                $event->setResponse(new RedirectResponse($url));
                return;
            }
        }

        $eventData['final_testmode'] = is_numeric($eventData['test_mode'])
            ? $eventData['test_mode']
            : ($this->novalnetHelper->decodeParams(
                $eventData['test_mode'],
                $paymentAccessKey,
                $eventData['uniqid']
            ));

        $this->novalnetHelper->insertNovalnetTransactionTable($this->doctrineHelper, $eventData, $paymentAccessKey);
        $this->novalnetHelper->setPaymentComments(
            $paymentTransaction,
            $this->doctrineHelper,
            $this->translator,
            $eventData
        );

        $paymentTransaction->setReference($eventData['tid']);

        try {
            $paymentMethod = $this->paymentProvider->getPaymentMethod($paymentTransaction->getPaymentMethod());
            // set payment status
            $pendingPayment = [91, 85, 99, 86, 98, 90, 75];
            if ((in_array($eventData['tid_status'], $pendingPayment))
                || (in_array($eventData['payment_type'], ['INVOICE_START', 'CASHPAYMENT']))) {
                $paymentMethod->execute(NovalnetPaymentMethod::PENDING, $paymentTransaction);
            } else {
                $paymentMethod->execute(NovalnetPaymentMethod::COMPLETE, $paymentTransaction);
            }
            $event->markSuccessful();
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

        $eventData = $event->getData();
        $paymentTransaction = $event->getPaymentTransaction();
        $this->novalnetCallback->startProcess($event, $this->logger, $this->paymentProvider);
        
        $event->markSuccessful();
        
    }
}
