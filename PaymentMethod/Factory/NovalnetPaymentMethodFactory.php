<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetHelper;
use Symfony\Component\Routing\RouterInterface;
use Oro\Bundle\EntityBundle\ORM\DoctrineHelper;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Contracts\Translation\TranslatorInterface;
use Oro\Bundle\FrontendLocalizationBundle\Manager\UserLocalizationManagerInterface;
use Novalnet\Bundle\NovalnetBundle\Client\GatewayInterface;
use Oro\Bundle\PaymentBundle\Provider\MethodsConfigsRule\Context\MethodsConfigsRulesByContextProviderInterface;

/**
 * Novalnet payment method factory
 */
abstract class NovalnetPaymentMethodFactory
{
    /**
     * @var RouterInterface
     */
    protected $routerInterface;

    /**
     * @var DoctrineHelper
     */
    protected $doctrineHelper;

    /**
     * @var NovalnetHelper
     */
    protected $novalnetHelper;

    /**
     * @var RequestStack
     */
    protected $requestStack;

    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @var UserLocalizationManagerInterface
     */
    protected $userLocalizationManager;

    /**
     * @var GatewayInterface
     */
    protected $client;

    /**
     * @var PaymentMethodProviderInterface
     */
    protected $paymentMethodProvider;

    /**
     * @param RouterInterface $routerInterface
     * @param DoctrineHelper $doctrineHelper
     * @param NovalnetHelper $novalnetHelper
     * @param RequestStack $requestStack
     * @param TranslatorInterface $translator
     * @param UserLocalizationManagerInterface $userLocalizationManager
     * @param GatewayInterface $client
     */
    public function __construct(
        RouterInterface $routerInterface,
        DoctrineHelper $doctrineHelper,
        NovalnetHelper $novalnetHelper,
        RequestStack $requestStack,
        TranslatorInterface $translator,
        UserLocalizationManagerInterface $userLocalizationManager,
        GatewayInterface $client,
        MethodsConfigsRulesByContextProviderInterface $paymentMethodProvider
    ) {
        $this->routerInterface = $routerInterface;
        $this->doctrineHelper = $doctrineHelper;
        $this->novalnetHelper = $novalnetHelper;
        $this->requestStack = $requestStack;
        $this->translator = $translator;
        $this->userLocalizationManager = $userLocalizationManager;
        $this->client = $client;
        $this->paymentMethodProvider = $paymentMethodProvider;
    }
}
