<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetWechatpayConfigInterface;

/**
 * Novalnet payment method factory interface
 */
interface NovalnetWechatpayPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetWechatpayConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetWechatpayConfigInterface $config);
}
