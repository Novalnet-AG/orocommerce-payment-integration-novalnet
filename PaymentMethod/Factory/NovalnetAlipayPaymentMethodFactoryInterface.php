<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetAlipayConfigInterface;

/**
 * Novalnet payment method factory interface
 */
interface NovalnetAlipayPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetAlipayConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetAlipayConfigInterface $config);
}
