<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetBancontactConfigInterface;

/**
 * Novalnet payment method factory interface
 */
interface NovalnetBancontactPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetBancontactConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetBancontactConfigInterface $config);
}
