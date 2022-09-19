<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetGuaranteedSepaConfigInterface;

/**
 * Novalnet payment method factory interface
 */
interface NovalnetGuaranteedSepaPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetGuaranteedSepaConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetGuaranteedSepaConfigInterface $config);
}
