<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetEpsConfigInterface;

/**
 * Novalnet payment method factory interface
 */
interface NovalnetEpsPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetEpsConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetEpsConfigInterface $config);
}
