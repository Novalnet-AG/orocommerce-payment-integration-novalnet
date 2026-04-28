<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetMbwayPaymentMethod;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetMbwayConfigInterface;
use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;

/**
 * Factory allows to create Novalnet payment method, using
 * dynamic property NovalnetMbwayConfigInterface $config
 * NovalnetMbwayPaymentMethod depends on this dynamic evaluated config
 * so it can not be defined directly in di and requires factory to create it
 */
class NovalnetMbwayPaymentMethodFactory extends NovalnetPaymentMethodFactory implements
    NovalnetMbwayPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetMbwayConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetMbwayConfigInterface $config)
    {
        return new NovalnetMbwayPaymentMethod(
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