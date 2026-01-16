<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetAchConfigInterface;

/**
 * Interface for config provider of Novalnet payment method
 */
interface NovalnetAchConfigProviderInterface extends NovalnetConfigProviderInterface
{
    /**
     * @return NovalnetAchConfigInterface[]
     */
    public function getPaymentConfigs();

    /**
     * @param string $identifier
     *
     * @return NovalnetAchConfigInterface|null
     */
    public function getPaymentConfig($identifier);
}