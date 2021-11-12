<?php

namespace Oro\Bundle\NovalnetPaymentBundle\PaymentMethod\Config\Factory;

use Oro\Bundle\NovalnetPaymentBundle\Entity\NovalnetPaymentSettings;
use Oro\Bundle\NovalnetPaymentBundle\PaymentMethod\Config\NovalnetPaymentConfigInterface;

/**
 * Interface for Novalnet payment method config factory
 * Creates instances of NovalnetPaymentSettings with configuration for payment method
 */
interface NovalnetPaymentConfigFactoryInterface
{
    /**
     * @param NovalnetPaymentSettings $settings
     * @return NovalnetPaymentConfigInterface
     */
    public function create(NovalnetPaymentSettings $settings);
}
