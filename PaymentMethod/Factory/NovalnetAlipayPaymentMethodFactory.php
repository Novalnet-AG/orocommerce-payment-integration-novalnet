<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetAlipayPaymentMethod;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetAlipayConfigInterface;
use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;

/**
 * Factory allows to create Novalnet payment method, using
 * dynamic property NovalnetAlipayConfigInterface $config
 * NovalnetAlipayPaymentMethod depends on this dynamic evaluated config
 * so it can not be defined directly in di and requires factory to create it
 */
class NovalnetAlipayPaymentMethodFactory extends NovalnetPaymentMethodFactory implements
    NovalnetAlipayPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetAlipayConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetAlipayConfigInterface $config)
    {
        return new NovalnetAlipayPaymentMethod(
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
