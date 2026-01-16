<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetIdealConfigInterface;

/**
 * Interface for config provider of Novalnet payment method
 */
interface NovalnetIdealConfigProviderInterface extends NovalnetConfigProviderInterface
{
    /**
     * @return NovalnetIdealConfigInterface[]
     */
    public function getPaymentConfigs();

    /**
     * @param string $identifier
     *
     * @return NovalnetIdealConfigInterface|null
     */
    public function getPaymentConfig($identifier);
}
