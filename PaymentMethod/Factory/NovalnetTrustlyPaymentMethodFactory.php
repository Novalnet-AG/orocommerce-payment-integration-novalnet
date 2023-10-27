<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetTrustlyPaymentMethod;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetTrustlyConfigInterface;
use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;

/**
 * Factory allows to create Novalnet payment method, using
 * dynamic property NovalnetTrustlyConfigInterface $config
 * NovalnetTrustlyPaymentMethod depends on this dynamic evaluated config
 * so it can not be defined directly in di and requires factory to create it
 */
class NovalnetTrustlyPaymentMethodFactory extends NovalnetPaymentMethodFactory implements
    NovalnetTrustlyPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetTrustlyConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetTrustlyConfigInterface $config)
    {
        return new NovalnetTrustlyPaymentMethod(
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
