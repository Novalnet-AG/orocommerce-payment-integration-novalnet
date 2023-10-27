<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetMultibancoConfigInterface;

/**
 * Interface for config provider of Novalnet payment method
 */
interface NovalnetMultibancoConfigProviderInterface extends NovalnetConfigProviderInterface
{
    /**
     * @return NovalnetMultibancoConfigInterface[]
     */
    public function getPaymentConfigs();

    /**
     * @param string $identifier
     *
     * @return NovalnetMultibancoConfigInterface|null
     */
    public function getPaymentConfig($identifier);
}
