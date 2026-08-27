<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetBancontactConfigInterface;

/**
 * Interface for config provider of Novalnet payment method
 */
interface NovalnetBancontactConfigProviderInterface extends NovalnetConfigProviderInterface
{
    /**
     * @return NovalnetBancontactConfigInterface[]
     */
    public function getPaymentConfigs();

    /**
     * @param string $identifier
     *
     * @return NovalnetBancontactConfigInterface|null
     */
    public function getPaymentConfig($identifier);
}
