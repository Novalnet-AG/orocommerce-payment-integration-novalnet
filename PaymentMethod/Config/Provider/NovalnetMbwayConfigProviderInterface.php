<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetMbwayConfigInterface;

/**
 * Interface for config provider of Novalnet payment method
 */
interface NovalnetMbwayConfigProviderInterface extends NovalnetConfigProviderInterface
{
    /**
     * @return NovalnetMbwayConfigInterface[]
     */
    public function getPaymentConfigs();

    /**
     * @param string $identifier
     *
     * @return NovalnetMbwayConfigInterface|null
     */
    public function getPaymentConfig($identifier);
}