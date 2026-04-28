<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetAchPaymentMethod;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetAchConfigInterface;
use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;

/**
 * Factory allows to create Novalnet payment method, using
 * dynamic property NovalnetAchConfigInterface $config
 * NovalnetAchPaymentMethod depends on this dynamic evaluated config
 * so it can not be defined directly in di and requires factory to create it
 */
class NovalnetAchPaymentMethodFactory extends NovalnetPaymentMethodFactory implements
    NovalnetAchPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetAchConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetAchConfigInterface $config)
    {
        return new NovalnetAchPaymentMethod(
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