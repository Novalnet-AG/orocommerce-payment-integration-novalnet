<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetPostfinanceCardPaymentMethod;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPostfinanceCardConfigInterface;
use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;

/**
 * Factory allows to create Novalnet payment method, using
 * dynamic property NovalnetPostfinanceCardConfigInterface $config
 * NovalnetPostfinanceCardPaymentMethod depends on this dynamic evaluated config
 * so it can not be defined directly in di and requires factory to create it
 */
class NovalnetPostfinanceCardPaymentMethodFactory extends NovalnetPaymentMethodFactory implements
    NovalnetPostfinanceCardPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetPostfinanceCardConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetPostfinanceCardConfigInterface $config)
    {
        return new NovalnetPostfinanceCardPaymentMethod(
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
