<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetNaverpayConfigInterface;

/**
 * Novalnet payment method factory interface
 */
interface NovalnetNaverpayPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetNaverpayConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetNaverpayConfigInterface $config);
}