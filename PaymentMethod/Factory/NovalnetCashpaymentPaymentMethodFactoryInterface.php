<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetCashpaymentConfigInterface;

/**
 * Novalnet payment method factory interface
 */
interface NovalnetCashpaymentPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetCashpaymentConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetCashpaymentConfigInterface $config);
}
