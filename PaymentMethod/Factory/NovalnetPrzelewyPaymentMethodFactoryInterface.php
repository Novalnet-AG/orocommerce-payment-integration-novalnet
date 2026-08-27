<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPrzelewyConfigInterface;

/**
 * Novalnet payment method factory interface
 */
interface NovalnetPrzelewyPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetPrzelewyConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetPrzelewyConfigInterface $config);
}
