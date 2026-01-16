<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetMultibancoConfigInterface;

/**
 * Novalnet payment method factory interface
 */
interface NovalnetMultibancoPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetMultibancoConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetMultibancoConfigInterface $config);
}
