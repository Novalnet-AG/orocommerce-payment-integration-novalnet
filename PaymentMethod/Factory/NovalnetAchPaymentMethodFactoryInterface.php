<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetAchConfigInterface;

/**
 * Novalnet payment method factory interface
 */
interface NovalnetAchPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetAchConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetAchConfigInterface $config);
}