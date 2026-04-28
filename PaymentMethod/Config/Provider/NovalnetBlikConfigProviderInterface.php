<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetBlikConfigInterface;

/**
 * Interface for config provider of Novalnet payment method
 */
interface NovalnetBlikConfigProviderInterface extends NovalnetConfigProviderInterface
{
    /**
     * @return NovalnetBlikConfigInterface[]
     */
    public function getPaymentConfigs();

    /**
     * @param string $identifier
     *
     * @return NovalnetBlikConfigInterface|null
     */
    public function getPaymentConfig($identifier);
}