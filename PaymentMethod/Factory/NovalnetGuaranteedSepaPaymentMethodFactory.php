<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetGuaranteedSepaPaymentMethod;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetGuaranteedSepaConfigInterface;
use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;

/**
 * Factory allows to create Novalnet payment method, using
 * dynamic property NovalnetGuaranteedSepaConfigInterface $config
 * NovalnetGuaranteedSepaPaymentMethod depends on this dynamic evaluated config
 * so it can not be defined directly in di and requires factory to create it
 */
class NovalnetGuaranteedSepaPaymentMethodFactory extends NovalnetPaymentMethodFactory implements
    NovalnetGuaranteedSepaPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetGuaranteedSepaConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetGuaranteedSepaConfigInterface $config)
    {
        return new NovalnetGuaranteedSepaPaymentMethod(
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
