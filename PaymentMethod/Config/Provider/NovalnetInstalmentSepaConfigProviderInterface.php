<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetInstalmentSepaConfigInterface;

/**
 * Interface for config provider of Novalnet payment method
 */
interface NovalnetInstalmentSepaConfigProviderInterface extends NovalnetConfigProviderInterface
{
    /**
     * @return NovalnetInstalmentSepaConfigInterface[]
     */
    public function getPaymentConfigs();

    /**
     * @param string $identifier
     *
     * @return NovalnetInstalmentSepaConfigInterface|null
     */
    public function getPaymentConfig($identifier);
}
