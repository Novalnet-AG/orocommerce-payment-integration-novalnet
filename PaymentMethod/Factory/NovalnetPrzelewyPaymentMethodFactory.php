<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetPrzelewyPaymentMethod;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPrzelewyConfigInterface;
use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;

/**
 * Factory allows to create Novalnet payment method, using
 * dynamic property NovalnetPrzelewyConfigInterface $config
 * NovalnetPrzelewyPaymentMethod depends on this dynamic evaluated config
 * so it can not be defined directly in di and requires factory to create it
 */
class NovalnetPrzelewyPaymentMethodFactory extends NovalnetPaymentMethodFactory implements
    NovalnetPrzelewyPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetPrzelewyConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetPrzelewyConfigInterface $config)
    {
        return new NovalnetPrzelewyPaymentMethod(
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
