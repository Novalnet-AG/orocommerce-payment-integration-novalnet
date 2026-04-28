<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetTwintConfigInterface;

/**
 * Interface for config provider of Novalnet payment method
 */
interface NovalnetTwintConfigProviderInterface extends NovalnetConfigProviderInterface
{
    /**
     * @return NovalnetTwintConfigInterface[]
     */
    public function getPaymentConfigs();

    /**
     * @param string $identifier
     *
     * @return NovalnetTwintConfigInterface|null
     */
    public function getPaymentConfig($identifier);
}