<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetEpsPaymentMethod;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetEpsConfigInterface;
use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;

/**
 * Factory allows to create Novalnet payment method, using
 * dynamic property NovalnetEpsConfigInterface $config
 * NovalnetEpsPaymentMethod depends on this dynamic evaluated config
 * so it can not be defined directly in di and requires factory to create it
 */
class NovalnetEpsPaymentMethodFactory extends NovalnetPaymentMethodFactory implements
    NovalnetEpsPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetEpsConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetEpsConfigInterface $config)
    {
        return new NovalnetEpsPaymentMethod(
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
