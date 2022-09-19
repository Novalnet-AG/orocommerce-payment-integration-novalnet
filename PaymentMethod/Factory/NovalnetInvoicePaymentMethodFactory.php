<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetInvoicePaymentMethod;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetInvoiceConfigInterface;
use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;

/**
 * Factory allows to create Novalnet payment method, using
 * dynamic property NovalnetInvoiceConfigInterface $config
 * NovalnetInvoicePaymentMethod depends on this dynamic evaluated config
 * so it can not be defined directly in di and requires factory to create it
 */
class NovalnetInvoicePaymentMethodFactory extends NovalnetPaymentMethodFactory implements
    NovalnetInvoicePaymentMethodFactoryInterface
{
    /**
     * @param NovalnetInvoiceConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetInvoiceConfigInterface $config)
    {
        return new NovalnetInvoicePaymentMethod(
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
