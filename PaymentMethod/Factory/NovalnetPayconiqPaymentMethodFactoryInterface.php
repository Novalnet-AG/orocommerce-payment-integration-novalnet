<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPayconiqConfigInterface;

/**
 * Novalnet payment method factory interface
 */
interface NovalnetPayconiqPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetPayconiqConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetPayconiqConfigInterface $config);
}