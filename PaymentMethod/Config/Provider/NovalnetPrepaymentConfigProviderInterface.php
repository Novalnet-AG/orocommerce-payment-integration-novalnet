<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPrepaymentConfigInterface;

/**
 * Interface for config provider of Novalnet payment method
 */
interface NovalnetPrepaymentConfigProviderInterface extends NovalnetConfigProviderInterface
{
    /**
     * @return NovalnetPrepaymentConfigInterface[]
     */
    public function getPaymentConfigs();

    /**
     * @param string $identifier
     *
     * @return NovalnetPrepaymentConfigInterface|null
     */
    public function getPaymentConfig($identifier);
}
