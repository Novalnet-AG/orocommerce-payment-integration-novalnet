<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetConfigInterface;

/**
 * Interface for config provider of Novalnet payment method
 */
interface NovalnetConfigProviderInterface
{
    /**
     * @return NovalnetConfigInterface[]
     */
    public function getPaymentConfigs();

    /**
     * @param string $identifier
     * @return NovalnetConfigInterface|null
     */
    public function getPaymentConfig($identifier);

    /**
     * @param string $identifier
     * @return bool
     */
    public function hasPaymentConfig($identifier);
}
