<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetGuaranteedInvoicePaymentMethod;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetGuaranteedInvoiceConfigInterface;
use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;

/**
 * Factory allows to create Novalnet payment method, using
 * dynamic property NovalnetGuaranteedInvoiceConfigInterface $config
 * NovalnetGuaranteedInvoicePaymentMethod depends on this dynamic evaluated config
 * so it can not be defined directly in di and requires factory to create it
 */
class NovalnetGuaranteedInvoicePaymentMethodFactory extends NovalnetPaymentMethodFactory implements
    NovalnetGuaranteedInvoicePaymentMethodFactoryInterface
{
    /**
     * @param NovalnetGuaranteedInvoiceConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetGuaranteedInvoiceConfigInterface $config)
    {
        return new NovalnetGuaranteedInvoicePaymentMethod(
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
