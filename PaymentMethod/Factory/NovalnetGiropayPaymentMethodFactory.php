<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetGiropayPaymentMethod;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetHelper;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetGiropayConfigInterface;
use Symfony\Component\Routing\RouterInterface;
use Oro\Bundle\EntityBundle\ORM\DoctrineHelper;
use Symfony\Component\HttpFoundation\RequestStack;
use Oro\Bundle\FrontendLocalizationBundle\Manager\UserLocalizationManager;
use Novalnet\Bundle\NovalnetBundle\Client\GatewayInterface;

/**
 * Factory allows to create Novalnet payment method, using
 * dynamic property NovalnetGiropayConfigInterface $config
 * NovalnetGiropayPaymentMethod depends on this dynamic evaluated config
 * so it can not be defined directly in di and requires factory to create it
 */
class NovalnetGiropayPaymentMethodFactory extends NovalnetPaymentMethodFactory implements
    NovalnetGiropayPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetGiropayConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetGiropayConfigInterface $config)
    {
        return new NovalnetGiropayPaymentMethod(
            $config,
            $this->routerInterface,
            $this->doctrineHelper,
            $this->novalnetHelper,
            $this->requestStack,
            $this->translator,
            $this->userLocalizationManager,
            $this->client
        );
    }
}
