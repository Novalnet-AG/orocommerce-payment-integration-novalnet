<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetSepaConfigInterface;

/**
 * Interface for config provider of Novalnet payment method
 */
interface NovalnetSepaConfigProviderInterface extends NovalnetConfigProviderInterface
{
    /**
     * @return NovalnetSepaConfigInterface[]
     */
    public function getPaymentConfigs();

    /**
     * @param string $identifier
     *
     * @return NovalnetSepaConfigInterface|null
     */
    public function getPaymentConfig($identifier);
}
