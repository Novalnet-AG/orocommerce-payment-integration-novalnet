<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetWechatpayConfigInterface;

/**
 * Interface for config provider of Novalnet payment method
 */
interface NovalnetWechatpayConfigProviderInterface extends NovalnetConfigProviderInterface
{
    /**
     * @return NovalnetWechatpayConfigInterface[]
     */
    public function getPaymentConfigs();

    /**
     * @param string $identifier
     *
     * @return NovalnetWechatpayConfigInterface|null
     */
    public function getPaymentConfig($identifier);
}
