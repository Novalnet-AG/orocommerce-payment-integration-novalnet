<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetPaypalPaymentMethod;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPaypalConfigInterface;
use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;

/**
 * Factory allows to create Novalnet payment method, using
 * dynamic property NovalnetPaypalConfigInterface $config
 * NovalnetPaypalPaymentMethod depends on this dynamic evaluated config
 * so it can not be defined directly in di and requires factory to create it
 */
class NovalnetPaypalPaymentMethodFactory extends NovalnetPaymentMethodFactory implements
    NovalnetPaypalPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetPaypalConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetPaypalConfigInterface $config)
    {
        return new NovalnetPaypalPaymentMethod(
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
