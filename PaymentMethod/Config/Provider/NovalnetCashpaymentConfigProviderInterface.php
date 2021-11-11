<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetCashpaymentConfigInterface;

/**
 * Interface for config provider of Novalnet payment method
 */
interface NovalnetCashpaymentConfigProviderInterface extends NovalnetConfigProviderInterface
{
    /**
     * @return NovalnetCashpaymentConfigInterface[]
     */
    public function getPaymentConfigs();

    /**
     * @param string $identifier
     *
     * @return NovalnetCashpaymentConfigInterface|null
     */
    public function getPaymentConfig($identifier);
}
