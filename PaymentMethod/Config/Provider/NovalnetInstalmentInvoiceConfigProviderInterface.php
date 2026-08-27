<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetInstalmentInvoiceConfigInterface;

/**
 * Interface for config provider of Novalnet payment method
 */
interface NovalnetInstalmentInvoiceConfigProviderInterface extends NovalnetConfigProviderInterface
{
    /**
     * @return NovalnetInstalmentInvoiceConfigInterface[]
     */
    public function getPaymentConfigs();

    /**
     * @param string $identifier
     *
     * @return NovalnetInstalmentInvoiceConfigInterface|null
     */
    public function getPaymentConfig($identifier);
}
