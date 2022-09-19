<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetGiropayConfigInterface;

/**
 * Interface for config provider of Novalnet payment method
 */
interface NovalnetGiropayConfigProviderInterface extends NovalnetConfigProviderInterface
{
    /**
     * @return NovalnetGiropayConfigInterface[]
     */
    public function getPaymentConfigs();

    /**
     * @param string $identifier
     *
     * @return NovalnetGiropayConfigInterface|null
     */
    public function getPaymentConfig($identifier);
}
