<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetGuaranteedInvoiceConfigInterface;

/**
 * Novalnet payment method factory interface
 */
interface NovalnetGuaranteedInvoicePaymentMethodFactoryInterface
{
    /**
     * @param NovalnetGuaranteedInvoiceConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetGuaranteedInvoiceConfigInterface $config);
}
