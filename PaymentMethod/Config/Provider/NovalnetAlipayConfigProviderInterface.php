<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetAlipayConfigInterface;

/**
 * Interface for config provider of Novalnet payment method
 */
interface NovalnetAlipayConfigProviderInterface extends NovalnetConfigProviderInterface
{
    /**
     * @return NovalnetAlipayConfigInterface[]
     */
    public function getPaymentConfigs();

    /**
     * @param string $identifier
     *
     * @return NovalnetAlipayConfigInterface|null
     */
    public function getPaymentConfig($identifier);
}
