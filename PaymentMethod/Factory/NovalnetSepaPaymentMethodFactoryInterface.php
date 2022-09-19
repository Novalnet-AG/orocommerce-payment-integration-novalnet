<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetSepaConfigInterface;

/**
 * Novalnet payment method factory interface
 */
interface NovalnetSepaPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetSepaConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetSepaConfigInterface $config);
}
