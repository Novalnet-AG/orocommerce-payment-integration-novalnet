<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetBanktransferPaymentMethod;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetBanktransferConfigInterface;
use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;

/**
 * Factory allows to create Novalnet payment method, using
 * dynamic property NovalnetBanktransferConfigInterface $config
 * NovalnetBanktransferPaymentMethod depends on this dynamic evaluated config
 * so it can not be defined directly in di and requires factory to create it
 */
class NovalnetBanktransferPaymentMethodFactory extends NovalnetPaymentMethodFactory implements
    NovalnetBanktransferPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetBanktransferConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetBanktransferConfigInterface $config)
    {
        return new NovalnetBanktransferPaymentMethod(
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
