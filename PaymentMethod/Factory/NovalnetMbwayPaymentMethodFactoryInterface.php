<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetMbwayConfigInterface;

/**
 * Novalnet payment method factory interface
 */
interface NovalnetMbwayPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetMbwayConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetMbwayConfigInterface $config);
}