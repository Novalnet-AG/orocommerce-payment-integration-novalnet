<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetKakaopayPaymentMethod;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetKakaopayConfigInterface;
use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;

/**
 * Factory allows to create Novalnet payment method, using
 * dynamic property NovalnetKakaopayConfigInterface $config
 * NovalnetKakaopayPaymentMethod depends on this dynamic evaluated config
 * so it can not be defined directly in di and requires factory to create it
 */
class NovalnetKakaopayPaymentMethodFactory extends NovalnetPaymentMethodFactory implements
    NovalnetKakaopayPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetKakaopayConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetKakaopayConfigInterface $config)
    {
        return new NovalnetKakaopayPaymentMethod(
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