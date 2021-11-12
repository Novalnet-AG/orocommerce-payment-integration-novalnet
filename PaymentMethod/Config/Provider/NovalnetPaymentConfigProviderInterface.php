<?php

namespace Oro\Bundle\NovalnetPaymentBundle\PaymentMethod\Config\Provider;

use Oro\Bundle\NovalnetPaymentBundle\PaymentMethod\Config\NovalnetPaymentConfigInterface;

/**
 * Interface for config provider which allows to get configs based on payment method identifier
 */
interface NovalnetPaymentConfigProviderInterface
{
    /**
     * @return NovalnetPaymentConfigInterface[]
     */
    public function getPaymentConfigs();

    /**
     * @param string $identifier
     * @return NovalnetPaymentConfigInterface|null
     */
    public function getPaymentConfig($identifier);

    /**
     * @param string $identifier
     * @return bool
     */
    public function hasPaymentConfig($identifier);
}
