<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetSepaPaymentMethod;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetSepaConfigInterface;
use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;

/**
 * Factory allows to create Novalnet payment method, using
 * dynamic property NovalnetSepaConfigInterface $config
 * NovalnetSepaPaymentMethod depends on this dynamic evaluated config
 * so it can not be defined directly in di and requires factory to create it
 */
class NovalnetSepaPaymentMethodFactory extends NovalnetPaymentMethodFactory implements
    NovalnetSepaPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetSepaConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetSepaConfigInterface $config)
    {
        return new NovalnetSepaPaymentMethod(
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
