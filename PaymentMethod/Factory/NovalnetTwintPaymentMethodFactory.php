<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetTwintPaymentMethod;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetTwintConfigInterface;
use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;

/**
 * Factory allows to create Novalnet payment method, using
 * dynamic property NovalnetTwintConfigInterface $config
 * NovalnetTwintPaymentMethod depends on this dynamic evaluated config
 * so it can not be defined directly in di and requires factory to create it
 */
class NovalnetTwintPaymentMethodFactory extends NovalnetPaymentMethodFactory implements
    NovalnetTwintPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetTwintConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetTwintConfigInterface $config)
    {
        return new NovalnetTwintPaymentMethod(
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