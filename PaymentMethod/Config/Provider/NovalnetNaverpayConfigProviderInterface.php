<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetNaverpayConfigInterface;

/**
 * Interface for config provider of Novalnet payment method
 */
interface NovalnetNaverpayConfigProviderInterface extends NovalnetConfigProviderInterface
{
    /**
     * @return NovalnetNaverpayConfigInterface[]
     */
    public function getPaymentConfigs();

    /**
     * @param string $identifier
     *
     * @return NovalnetNaverpayConfigInterface|null
     */
    public function getPaymentConfig($identifier);
}