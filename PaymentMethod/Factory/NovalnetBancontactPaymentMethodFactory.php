<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetBancontactPaymentMethod;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetBancontactConfigInterface;
use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;

/**
 * Factory allows to create Novalnet payment method, using
 * dynamic property NovalnetBancontactConfigInterface $config
 * NovalnetBancontactPaymentMethod depends on this dynamic evaluated config
 * so it can not be defined directly in di and requires factory to create it
 */
class NovalnetBancontactPaymentMethodFactory extends NovalnetPaymentMethodFactory implements
    NovalnetBancontactPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetBancontactConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetBancontactConfigInterface $config)
    {
        return new NovalnetBancontactPaymentMethod(
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
