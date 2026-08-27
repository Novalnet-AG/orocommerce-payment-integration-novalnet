<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetInvoiceConfigInterface;

/**
 * Interface for config provider of Novalnet payment method
 */
interface NovalnetInvoiceConfigProviderInterface extends NovalnetConfigProviderInterface
{
    /**
     * @return NovalnetInvoiceConfigInterface[]
     */
    public function getPaymentConfigs();

    /**
     * @param string $identifier
     *
     * @return NovalnetInvoiceConfigInterface|null
     */
    public function getPaymentConfig($identifier);
}
