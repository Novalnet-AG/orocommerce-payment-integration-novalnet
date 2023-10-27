<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetGuaranteedSepaConfigInterface;

/**
 * Interface for config provider of Novalnet payment method
 */
interface NovalnetGuaranteedSepaConfigProviderInterface extends NovalnetConfigProviderInterface
{
    /**
     * @return NovalnetGuaranteedSepaConfigInterface[]
     */
    public function getPaymentConfigs();

    /**
     * @param string $identifier
     *
     * @return NovalnetGuaranteedSepaConfigInterface|null
     */
    public function getPaymentConfig($identifier);
}
