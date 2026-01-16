<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPostfinanceConfigInterface;

/**
 * Interface for config provider of Novalnet payment method
 */
interface NovalnetPostfinanceConfigProviderInterface extends NovalnetConfigProviderInterface
{
    /**
     * @return NovalnetPostfinanceConfigInterface[]
     */
    public function getPaymentConfigs();

    /**
     * @param string $identifier
     *
     * @return NovalnetPostfinanceConfigInterface|null
     */
    public function getPaymentConfig($identifier);
}
