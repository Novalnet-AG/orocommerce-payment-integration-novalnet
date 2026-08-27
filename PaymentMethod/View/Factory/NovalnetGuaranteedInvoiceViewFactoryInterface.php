<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetGuaranteedInvoiceConfigInterface;
use Oro\Bundle\PaymentBundle\Method\View\PaymentMethodViewInterface;

/**
 * Novalnet payment method view provider factory interface
 */
interface NovalnetGuaranteedInvoiceViewFactoryInterface
{
    /**
     * @param NovalnetGuaranteedInvoiceConfigInterface $config
     * @return PaymentMethodViewInterface
     */
    public function create(NovalnetGuaranteedInvoiceConfigInterface $config);
}
