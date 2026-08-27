<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetCreditCardConfigInterface;

/**
 * Novalnet payment method factory interface
 */
interface NovalnetCreditCardPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetSepaConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetCreditCardConfigInterface $config);
}
