<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetBanktransferConfigInterface;

/**
 * Interface for config provider of Novalnet payment method
 */
interface NovalnetBanktransferConfigProviderInterface extends NovalnetConfigProviderInterface
{
    /**
     * @return NovalnetBanktransferConfigInterface[]
     */
    public function getPaymentConfigs();

    /**
     * @param string $identifier
     *
     * @return NovalnetBanktransferConfigInterface|null
     */
    public function getPaymentConfig($identifier);
}
