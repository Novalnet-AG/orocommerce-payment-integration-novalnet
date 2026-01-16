<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetPayconiqPaymentMethod;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPayconiqConfigInterface;
use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;

/**
 * Factory allows to create Novalnet payment method, using
 * dynamic property NovalnetPayconiqConfigInterface $config
 * NovalnetPayconiqPaymentMethod depends on this dynamic evaluated config
 * so it can not be defined directly in di and requires factory to create it
 */
class NovalnetPayconiqPaymentMethodFactory extends NovalnetPaymentMethodFactory implements
    NovalnetPayconiqPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetPayconiqConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetPayconiqConfigInterface $config)
    {
        return new NovalnetPayconiqPaymentMethod(
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