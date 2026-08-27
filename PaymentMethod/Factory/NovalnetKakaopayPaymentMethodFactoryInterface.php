<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetKakaopayConfigInterface;

/**
 * Novalnet payment method factory interface
 */
interface NovalnetKakaopayPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetKakaopayConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetKakaopayConfigInterface $config);
}