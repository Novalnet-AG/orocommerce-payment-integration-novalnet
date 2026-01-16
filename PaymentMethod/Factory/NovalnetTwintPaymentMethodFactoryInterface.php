<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetTwintConfigInterface;

/**
 * Novalnet payment method factory interface
 */
interface NovalnetTwintPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetTwintConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetTwintConfigInterface $config);
}