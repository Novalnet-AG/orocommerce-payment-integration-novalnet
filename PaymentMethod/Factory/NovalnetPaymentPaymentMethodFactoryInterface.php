<?php

namespace Oro\Bundle\NovalnetPaymentBundle\PaymentMethod\Factory;

use Oro\Bundle\NovalnetPaymentBundle\PaymentMethod\Config\NovalnetPaymentConfigInterface;
use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;

/**
 * Interface of factories which create payment method instances based on configuration
 */
interface NovalnetPaymentPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetPaymentConfigInterface $config
     * @return PaymentMethodInterface
     */
    public function create(NovalnetPaymentConfigInterface $config);
}
