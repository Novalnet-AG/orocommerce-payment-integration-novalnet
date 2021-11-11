<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfigInterface;
use Oro\Bundle\PaymentBundle\Context\PaymentContextInterface;
use Oro\Bundle\PaymentBundle\Entity\PaymentTransaction;
use Oro\Bundle\PaymentBundle\Method\Action\PurchaseActionInterface;
use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;
use Symfony\Component\Routing\RouterInterface;
use Oro\Bundle\OrderBundle\Entity\Order;
use Oro\Bundle\EntityBundle\ORM\DoctrineHelper;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Translation\TranslatorInterface;
use Oro\Bundle\FrontendLocalizationBundle\Manager\UserLocalizationManager;
use Novalnet\Bundle\NovalnetBundle\Client\GatewayInterface;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

/**
 * Novalnet Payment Method
 */
abstract class NovalnetPaymentMethod implements PaymentMethodInterface
{
    const COMPLETE = 'complete';

    /**
     * @var NovalnetConfigInterface
     */
    public $config;

    /**
     * @var Router
     */
    protected $router;

    /**
     * @var Order
     */
    protected $order;

    /**
     * @var NovalnetHelper
     */
    protected $novalnetHelper;

    /**
     * @var DoctrineHelper
     */
    protected $doctrineHelper;

    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @var UserLocalizationManager
     */
    protected $userLocalizationManager;

    /**
     * @var GatewayInterface
     */
    protected $client;

    /**
     * @param NovalnetConfigInterface $config
     * @param RouterInterface $routerInterface
     * @param DoctrineHelper $doctrineHelper
     * @param NovalnetHelper $novalnetHelper
     * @param RequestStack $requestStack
     * @param TranslatorInterface $translator
     * @param UserLocalizationManager $userLocalizationManager
     * @param GatewayInterface $client
     */
    public function __construct(
        NovalnetConfigInterface $config,
        RouterInterface $routerInterface,
        DoctrineHelper $doctrineHelper,
        NovalnetHelper $novalnetHelper,
        RequestStack $requestStack,
        TranslatorInterface $translator,
        UserLocalizationManager $userLocalizationManager,
        GatewayInterface $client
    ) {
        $this->config = $config;
        $this->router = $routerInterface;
        $this->doctrineHelper = $doctrineHelper;
        $this->novalnetHelper = $novalnetHelper;
        $this->requestStack = $requestStack;
        $this->translator = $translator;
        $this->userLocalizationManager = $userLocalizationManager;
        $this->client = $client;
    }

    /**
     * {@inheritdoc}
     */
    public function execute($action, PaymentTransaction $paymentTransaction)
    {
        if (!method_exists($this, $action)) {
            throw new \InvalidArgumentException(
                sprintf('"%s" payment method "%s" action is not supported', $this->getIdentifier(), $action)
            );
        }
        return $this->$action($paymentTransaction);
    }


    /**
     * {@inheritdoc}
     */
    public function getIdentifier()
    {
        return $this->config->getPaymentMethodIdentifier();
    }

    /**
     * {@inheritdoc}
     */
    public function isApplicable(PaymentContextInterface $context)
    {
        if (empty($this->config->getVendorId())
            || empty($this->config->getAuthcode())
            || empty($this->config->getProduct())
            || empty($this->config->getTariff())
            || empty($this->config->getPaymentAccessKey())) {
            return false;
        }

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($actionName)
    {
        return in_array($actionName, [self::PURCHASE, self::COMPLETE, self::PENDING], true);
    }

    /**
     * {@inheritdoc}
     */
    public function purchase(PaymentTransaction $paymentTransaction)
    {

        $paymentTransaction
            ->setSuccessful(false)
            ->setActive(true);

        $order = $this->doctrineHelper->getEntity(
            $paymentTransaction->getEntityClass(),
            $paymentTransaction->getEntityIdentifier()
        );
        $request = $this->requestStack->getCurrentRequest();
        $params = $this->novalnetHelper->getBasicParams(
            $order,
            $this->config,
            $this->router,
            $paymentTransaction,
            $request,
            $this->userLocalizationManager
        );

        $response = $this->client->send('', $this->config, $params);
        parse_str($response, $result);
        $novalnetResponse = [];
        if ($result['status'] == '100' && !empty($result['url'])) {
            $novalnetResponse['purchaseRedirectUrl'] = $result['url'];
        } else {
            $paymentTransaction->setResponse($result);
        }
        return $novalnetResponse;
    }

    /**
     * {@inheritdoc}
     */
    public function complete(PaymentTransaction $paymentTransaction)
    {
        $paymentTransaction->setSuccessful(true);
        $paymentTransaction->setActive(false);
    }

    /**
     * {@inheritdoc}
     */
    public function pending(PaymentTransaction $paymentTransaction)
    {
        $paymentTransaction->setSuccessful(false);
        $paymentTransaction->setActive(true);
    }
}
