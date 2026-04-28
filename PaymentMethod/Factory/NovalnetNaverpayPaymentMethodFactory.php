<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetNaverpayPaymentMethod;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetNaverpayConfigInterface;
use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;

/**
 * Factory allows to create Novalnet payment method, using
 * dynamic property NovalnetNaverpayConfigInterface $config
 * NovalnetNaverpayPaymentMethod depends on this dynamic evaluated config
 * so it can not be defined directly in di and requires factory to create it
 */
class NovalnetNaverpayPaymentMethodFactory extends NovalnetPaymentMethodFactory implements
    NovalnetNaverpayPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetNaverpayConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetNaverpayConfigInterface $config)
    {
        return new NovalnetNaverpayPaymentMethod(
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