<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetIdealPaymentMethod;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetIdealConfigInterface;
use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;

/**
 * Factory allows to create Novalnet payment method, using
 * dynamic property NovalnetIdealConfigInterface $config
 * NovalnetIdealPaymentMethod depends on this dynamic evaluated config
 * so it can not be defined directly in di and requires factory to create it
 */
class NovalnetIdealPaymentMethodFactory extends NovalnetPaymentMethodFactory implements
    NovalnetIdealPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetIdealConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetIdealConfigInterface $config)
    {
        return new NovalnetIdealPaymentMethod(
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
