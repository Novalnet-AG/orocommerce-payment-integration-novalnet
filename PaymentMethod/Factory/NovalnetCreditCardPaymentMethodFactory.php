<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetCreditCardPaymentMethod;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetCreditCardConfigInterface;
use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;

/**
 * Factory allows to create Novalnet payment method, using
 * dynamic property NovalnetCreditCardConfigInterface $config
 * NovalnetCreditCardPaymentMethod depends on this dynamic evaluated config
 * so it can not be defined directly in di and requires factory to create it
 */
class NovalnetCreditCardPaymentMethodFactory extends NovalnetPaymentMethodFactory implements
    NovalnetCreditCardPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetCreditCardConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetCreditCardConfigInterface $config)
    {
        return new NovalnetCreditCardPaymentMethod(
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
