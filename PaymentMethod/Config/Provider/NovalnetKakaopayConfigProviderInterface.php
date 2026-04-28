<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetKakaopayConfigInterface;

/**
 * Interface for config provider of Novalnet payment method
 */
interface NovalnetKakaopayConfigProviderInterface extends NovalnetConfigProviderInterface
{
    /**
     * @return NovalnetKakaopayConfigInterface[]
     */
    public function getPaymentConfigs();

    /**
     * @param string $identifier
     *
     * @return NovalnetKakaopayConfigInterface|null
     */
    public function getPaymentConfig($identifier);
}