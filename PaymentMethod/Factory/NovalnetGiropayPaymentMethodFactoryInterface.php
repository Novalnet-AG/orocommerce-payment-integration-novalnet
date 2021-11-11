<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetGiropayConfigInterface;

/**
 * Novalnet payment method factory interface
 */
interface NovalnetGiropayPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetGiropayConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetGiropayConfigInterface $config);
}
