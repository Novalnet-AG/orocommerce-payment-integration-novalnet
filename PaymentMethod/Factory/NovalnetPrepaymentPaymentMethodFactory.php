<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetPrepaymentPaymentMethod;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPrepaymentConfigInterface;
use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;

/**
 * Factory allows to create Novalnet payment method, using
 * dynamic property NovalnetPrepaymentConfigInterface $config
 * NovalnetPrepaymentPaymentMethod depends on this dynamic evaluated config
 * so it can not be defined directly in di and requires factory to create it
 */
class NovalnetPrepaymentPaymentMethodFactory extends NovalnetPaymentMethodFactory implements
    NovalnetPrepaymentPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetPrepaymentConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetPrepaymentConfigInterface $config)
    {
        return new NovalnetPrepaymentPaymentMethod(
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
