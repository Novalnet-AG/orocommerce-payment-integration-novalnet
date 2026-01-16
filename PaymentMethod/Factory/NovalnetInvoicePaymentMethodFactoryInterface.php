<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetInvoiceConfigInterface;

/**
 * Novalnet payment method factory interface
 */
interface NovalnetInvoicePaymentMethodFactoryInterface
{
    /**
     * @param NovalnetInvoiceConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetInvoiceConfigInterface $config);
}
