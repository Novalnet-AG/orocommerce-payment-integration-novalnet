<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\Provider;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPostfinanceCardConfigInterface;

/**
 * Interface for config provider of Novalnet payment method
 */
interface NovalnetPostfinanceCardConfigProviderInterface extends NovalnetConfigProviderInterface
{
    /**
     * @return NovalnetPostfinanceCardConfigInterface[]
     */
    public function getPaymentConfigs();

    /**
     * @param string $identifier
     *
     * @return NovalnetPostfinanceCardConfigInterface|null
     */
    public function getPaymentConfig($identifier);
}
