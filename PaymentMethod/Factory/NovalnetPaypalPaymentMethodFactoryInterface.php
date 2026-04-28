<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPaypalConfigInterface;

/**
 * Novalnet payment method factory interface
 */
interface NovalnetPaypalPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetPaypalConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetPaypalConfigInterface $config);
}
