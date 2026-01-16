<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPrzelewyConfigInterface;

/**
 * Interface for config provider of Novalnet payment method
 */
interface NovalnetPrzelewyConfigProviderInterface extends NovalnetConfigProviderInterface
{
    /**
     * @return NovalnetPrzelewyConfigInterface[]
     */
    public function getPaymentConfigs();

    /**
     * @param string $identifier
     *
     * @return NovalnetPrzelewyConfigInterface|null
     */
    public function getPaymentConfig($identifier);
}
