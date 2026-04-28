<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetOnlinebanktransferPaymentMethod;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetOnlinebanktransferConfigInterface;
use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;

/**
 * Factory allows to create Novalnet payment method, using
 * dynamic property NovalnetOnlinebanktransferConfigInterface $config
 * NovalnetOnlinebanktransferPaymentMethod depends on this dynamic evaluated config
 * so it can not be defined directly in di and requires factory to create it
 */
class NovalnetOnlinebanktransferPaymentMethodFactory extends NovalnetPaymentMethodFactory implements
    NovalnetOnlinebanktransferPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetOnlinebanktransferConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetOnlinebanktransferConfigInterface $config)
    {
        return new NovalnetOnlinebanktransferPaymentMethod(
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
