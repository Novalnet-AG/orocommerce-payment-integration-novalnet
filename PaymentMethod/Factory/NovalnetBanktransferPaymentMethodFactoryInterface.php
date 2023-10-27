<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetBanktransferConfigInterface;

/**
 * Novalnet payment method factory interface
 */
interface NovalnetBanktransferPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetBanktransferConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetBanktransferConfigInterface $config);
}
