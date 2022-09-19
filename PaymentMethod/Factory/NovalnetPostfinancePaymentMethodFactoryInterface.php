<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPostfinanceConfigInterface;

/**
 * Novalnet payment method factory interface
 */
interface NovalnetPostfinancePaymentMethodFactoryInterface
{
    /**
     * @param NovalnetIdealConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetPostfinanceConfigInterface $config);
}
