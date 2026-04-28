<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetBlikPaymentMethod;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetBlikConfigInterface;
use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;

/**
 * Factory allows to create Novalnet payment method, using
 * dynamic property NovalnetBlikConfigInterface $config
 * NovalnetBlikPaymentMethod depends on this dynamic evaluated config
 * so it can not be defined directly in di and requires factory to create it
 */
class NovalnetBlikPaymentMethodFactory extends NovalnetPaymentMethodFactory implements
    NovalnetBlikPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetBlikConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetBlikConfigInterface $config)
    {
        return new NovalnetBlikPaymentMethod(
            $config,
            $this->routerInterface,
            $this->doctrineHelper,
            $this->novalnetHelper,
            $this->requestStack,
            $this->translator,
            $this->userLocalizationManager,
            $this->client,
            $this->paymentMethodProvider
        );
    }
}