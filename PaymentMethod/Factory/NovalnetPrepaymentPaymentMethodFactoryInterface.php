<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPrepaymentConfigInterface;

/**
 * Novalnet payment method factory interface
 */
interface NovalnetPrepaymentPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetPrepaymentConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetPrepaymentConfigInterface $config);
}
