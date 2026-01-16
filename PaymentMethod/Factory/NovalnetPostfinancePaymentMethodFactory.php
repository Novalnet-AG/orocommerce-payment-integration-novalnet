<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetPostfinancePaymentMethod;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPostfinanceConfigInterface;
use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;

/**
 * Factory allows to create Novalnet payment method, using
 * dynamic property NovalnetPostfinanceConfigInterface $config
 * NovalnetPostfinancePaymentMethod depends on this dynamic evaluated config
 * so it can not be defined directly in di and requires factory to create it
 */
class NovalnetPostfinancePaymentMethodFactory extends NovalnetPaymentMethodFactory implements
    NovalnetPostfinancePaymentMethodFactoryInterface
{
    /**
     * @param NovalnetPostfinanceConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetPostfinanceConfigInterface $config)
    {
        return new NovalnetPostfinancePaymentMethod(
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
