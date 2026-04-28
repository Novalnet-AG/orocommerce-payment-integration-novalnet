<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetEpsConfigInterface;

/**
 * Interface for config provider of Novalnet payment method
 */
interface NovalnetEpsConfigProviderInterface extends NovalnetConfigProviderInterface
{
    /**
     * @return NovalnetEpsConfigInterface[]
     */
    public function getPaymentConfigs();

    /**
     * @param string $identifier
     *
     * @return NovalnetEpsConfigInterface|null
     */
    public function getPaymentConfig($identifier);
}
