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
use Symfony\Contracts\Translation\TranslatorInterface;
use Oro\Bundle\FrontendLocalizationBundle\Manager\UserLocalizationManagerInterface;
use Novalnet\Bundle\NovalnetBundle\Client\GatewayInterface;
use Oro\Bundle\PaymentBundle\Provider\MethodsConfigsRule\Context\MethodsConfigsRulesByContextProviderInterface;
use Oro\Bundle\PaymentBundle\Entity\PaymentMethodsConfigsRule;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

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
     * @var RouterInterface
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
     * @var MethodsConfigsRulesByContextProviderInterface
     */
    protected $paymentMethodProvider;
    
    /**
     * @param NovalnetConfigInterface $config
     * @param RouterInterface $routerInterface
     * @param DoctrineHelper $doctrineHelper
     * @param NovalnetHelper $novalnetHelper
     * @param RequestStack $requestStack
     * @param TranslatorInterface $translator
     * @param UserLocalizationManagerInterface $userLocalizationManager
     * @param GatewayInterface $client
     */
    public function __construct(
        NovalnetConfigInterface $config,
        RouterInterface $routerInterface,
        DoctrineHelper $doctrineHelper,
        NovalnetHelper $novalnetHelper,
        RequestStack $requestStack,
        TranslatorInterface $translator,
        UserLocalizationManagerInterface $userLocalizationManager,
        GatewayInterface $client,
        MethodsConfigsRulesByContextProviderInterface $paymentMethodProvider
    ) {
        $this->config = $config;
        $this->router = $routerInterface;
        $this->doctrineHelper = $doctrineHelper;
        $this->novalnetHelper = $novalnetHelper;
        $this->requestStack = $requestStack;
        $this->translator = $translator;
        $this->userLocalizationManager = $userLocalizationManager;
        $this->client = $client;
        $this->paymentMethodProvider = $paymentMethodProvider;
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
    public function supports($actionName)
    {
        return in_array($actionName, [self::COMPLETE, self::PENDING, self::PURCHASE], true);
    }

    /**
     * {@inheritdoc}
     */
    public function complete(PaymentTransaction $paymentTransaction)
    {
        $paymentTransaction
            ->setSuccessful(true)
            ->setActive(false);
    }

    /**
     * {@inheritdoc}
     */
    public function pending(PaymentTransaction $paymentTransaction)
    {
        $paymentTransaction
            ->setSuccessful(false)
            ->setActive(true);
    }

    /**
     * {@inheritdoc}
     */
    public function getPaymentCode()
    {
        return preg_replace('/_[0-9]{1,}$/', '', $this->config->getPaymentMethodIdentifier());
    }
}
