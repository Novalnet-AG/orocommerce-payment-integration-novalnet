<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPayconiqConfigInterface;

/**
 * Interface for config provider of Novalnet payment method
 */
interface NovalnetPayconiqConfigProviderInterface extends NovalnetConfigProviderInterface
{
    /**
     * @return NovalnetPayconiqConfigInterface[]
     */
    public function getPaymentConfigs();

    /**
     * @param string $identifier
     *
     * @return NovalnetPayconiqConfigInterface|null
     */
    public function getPaymentConfig($identifier);
}