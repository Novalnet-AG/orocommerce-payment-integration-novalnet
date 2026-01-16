<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetInstalmentInvoiceConfigInterface;

/**
 * Novalnet payment method factory interface
 */
interface NovalnetInstalmentInvoicePaymentMethodFactoryInterface
{
    /**
     * @param NovalnetInstalmentInvoiceConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetInstalmentInvoiceConfigInterface $config);
}
