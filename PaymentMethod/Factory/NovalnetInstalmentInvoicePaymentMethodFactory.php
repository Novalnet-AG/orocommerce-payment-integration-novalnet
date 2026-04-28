<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetInstalmentInvoicePaymentMethod;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetInstalmentInvoiceConfigInterface;
use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;

/**
 * Factory allows to create Novalnet payment method, using
 * dynamic property NovalnetInstalmentInvoiceConfigInterface $config
 * NovalnetInstalmentInvoicePaymentMethod depends on this dynamic evaluated config
 * so it can not be defined directly in di and requires factory to create it
 */
class NovalnetInstalmentInvoicePaymentMethodFactory extends NovalnetPaymentMethodFactory implements
    NovalnetInstalmentInvoicePaymentMethodFactoryInterface
{
    /**
     * @param NovalnetInstalmentInvoiceConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetInstalmentInvoiceConfigInterface $config)
    {
        return new NovalnetInstalmentInvoicePaymentMethod(
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
