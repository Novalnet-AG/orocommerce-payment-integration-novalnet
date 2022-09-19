<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetInstalmentInvoiceConfigInterface;
use Oro\Bundle\PaymentBundle\Method\View\PaymentMethodViewInterface;

/**
 * Novalnet payment method view provider factory interface
 */
interface NovalnetInstalmentInvoiceViewFactoryInterface
{
    /**
     * @param NovalnetInstalmentInvoiceConfigInterface $config
     * @return PaymentMethodViewInterface
     */
    public function create(NovalnetInstalmentInvoiceConfigInterface $config);
}
