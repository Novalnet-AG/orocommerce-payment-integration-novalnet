<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetIdealConfigInterface;

/**
 * Novalnet payment method factory interface
 */
interface NovalnetIdealPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetIdealConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetIdealConfigInterface $config);
}
