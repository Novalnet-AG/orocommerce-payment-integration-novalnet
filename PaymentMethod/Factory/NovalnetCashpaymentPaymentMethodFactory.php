<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetCashpaymentPaymentMethod;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetCashpaymentConfigInterface;
use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;

/**
 * Factory allows to create Novalnet payment method, using
 * dynamic property NovalnetCashpaymentConfigInterface $config
 * NovalnetCashpaymentPaymentMethod depends on this dynamic evaluated config
 * so it can not be defined directly in di and requires factory to create it
 */
class NovalnetCashpaymentPaymentMethodFactory extends NovalnetPaymentMethodFactory implements
    NovalnetCashpaymentPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetCashpaymentConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetCashpaymentConfigInterface $config)
    {
        return new NovalnetCashpaymentPaymentMethod(
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
