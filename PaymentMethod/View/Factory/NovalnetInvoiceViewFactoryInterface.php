<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetInvoiceConfigInterface;
use Oro\Bundle\PaymentBundle\Method\View\PaymentMethodViewInterface;

/**
 * Novalnet payment method view provider factory interface
 */
interface NovalnetInvoiceViewFactoryInterface
{
    /**
     * @param NovalnetInvoiceConfigInterface $config
     * @return PaymentMethodViewInterface
     */
    public function create(NovalnetInvoiceConfigInterface $config);
}
