<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetMultibancoPaymentMethod;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetMultibancoConfigInterface;
use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;

/**
 * Factory allows to create Novalnet payment method, using
 * dynamic property NovalnetMultibancoConfigInterface $config
 * NovalnetMultibancoPaymentMethod depends on this dynamic evaluated config
 * so it can not be defined directly in di and requires factory to create it
 */
class NovalnetMultibancoPaymentMethodFactory extends NovalnetPaymentMethodFactory implements
    NovalnetMultibancoPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetMultibancoConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetMultibancoConfigInterface $config)
    {
        return new NovalnetMultibancoPaymentMethod(
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
