<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetGuaranteedInvoiceConfigInterface;

/**
 * Interface for config provider of Novalnet payment method
 */
interface NovalnetGuaranteedInvoiceConfigProviderInterface extends NovalnetConfigProviderInterface
{
    /**
     * @return NovalnetGuaranteedInvoiceConfigInterface[]
     */
    public function getPaymentConfigs();

    /**
     * @param string $identifier
     *
     * @return NovalnetGuaranteedInvoiceConfigInterface|null
     */
    public function getPaymentConfig($identifier);
}
