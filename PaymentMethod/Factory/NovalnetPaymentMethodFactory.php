<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetHelper;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfigInterface;
use Symfony\Component\Routing\RouterInterface;
use Oro\Bundle\EntityBundle\ORM\DoctrineHelper;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Translation\TranslatorInterface;
use Oro\Bundle\FrontendLocalizationBundle\Manager\UserLocalizationManager;
use Novalnet\Bundle\NovalnetBundle\Client\GatewayInterface;

/**
 * Novalnet payment method factory
 */
abstract class NovalnetPaymentMethodFactory
{
    /**
     * @var Router
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
     * @var UserLocalizationManager
     */
    protected $userLocalizationManager;

    /**
     * @var GatewayInterface
     */
    protected $client;

    /**
     * @param RouterInterface $routerInterface
     * @param DoctrineHelper $doctrineHelper
     * @param NovalnetHelper $novalnetHelper
     * @param RequestStack $requestStack
     * @param TranslatorInterface $translator
     * @param UserLocalizationManager $userLocalizationManager
     * @param GatewayInterface $client
     */
    public function __construct(
        RouterInterface $routerInterface,
        DoctrineHelper $doctrineHelper,
        NovalnetHelper $novalnetHelper,
        RequestStack $requestStack,
        TranslatorInterface $translator,
        UserLocalizationManager $userLocalizationManager,
        GatewayInterface $client
    ) {
        $this->routerInterface = $routerInterface;
        $this->doctrineHelper = $doctrineHelper;
        $this->novalnetHelper = $novalnetHelper;
        $this->requestStack = $requestStack;
        $this->translator = $translator;
        $this->userLocalizationManager = $userLocalizationManager;
        $this->client = $client;
    }
}
