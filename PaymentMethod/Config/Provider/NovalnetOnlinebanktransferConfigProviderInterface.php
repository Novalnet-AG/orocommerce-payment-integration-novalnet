<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetOnlinebanktransferConfigInterface;

/**
 * Interface for config provider of Novalnet payment method
 */
interface NovalnetOnlinebanktransferConfigProviderInterface extends NovalnetConfigProviderInterface
{
    /**
     * @return NovalnetOnlinebanktransferConfigInterface[]
     */
    public function getPaymentConfigs();

    /**
     * @param string $identifier
     *
     * @return NovalnetOnlinebanktransferConfigInterface|null
     */
    public function getPaymentConfig($identifier);
}
