<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPostfinanceCardConfigInterface;

/**
 * Novalnet payment method factory interface
 */
interface NovalnetPostfinanceCardPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetPostfinanceCardConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetPostfinanceCardConfigInterface $config);
}
