<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetTrustlyConfigInterface;

/**
 * Novalnet payment method factory interface
 */
interface NovalnetTrustlyPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetTrustlyConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetTrustlyConfigInterface $config);
}
