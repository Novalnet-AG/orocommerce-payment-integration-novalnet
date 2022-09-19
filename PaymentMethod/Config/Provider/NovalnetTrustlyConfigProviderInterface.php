<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetTrustlyConfigInterface;

/**
 * Interface for config provider of Novalnet payment method
 */
interface NovalnetTrustlyConfigProviderInterface extends NovalnetConfigProviderInterface
{
    /**
     * @return NovalnetTrustlyConfigInterface[]
     */
    public function getPaymentConfigs();

    /**
     * @param string $identifier
     *
     * @return NovalnetTrustlyConfigInterface|null
     */
    public function getPaymentConfig($identifier);
}
