<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPaypalConfigInterface;

/**
 * Interface for config provider of Novalnet payment method
 */
interface NovalnetPaypalConfigProviderInterface extends NovalnetConfigProviderInterface
{
    /**
     * @return NovalnetPaypalConfigInterface[]
     */
    public function getPaymentConfigs();

    /**
     * @param string $identifier
     *
     * @return NovalnetPaypalConfigInterface|null
     */
    public function getPaymentConfig($identifier);
}
