<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetWechatpayPaymentMethod;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetWechatpayConfigInterface;
use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;

/**
 * Factory allows to create Novalnet payment method, using
 * dynamic property NovalnetWechatpayConfigInterface $config
 * NovalnetWechatpayPaymentMethod depends on this dynamic evaluated config
 * so it can not be defined directly in di and requires factory to create it
 */
class NovalnetWechatpayPaymentMethodFactory extends NovalnetPaymentMethodFactory implements
    NovalnetWechatpayPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetWechatpayConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetWechatpayConfigInterface $config)
    {
        return new NovalnetWechatpayPaymentMethod(
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
