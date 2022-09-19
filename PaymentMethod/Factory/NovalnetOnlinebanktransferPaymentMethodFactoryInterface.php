<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\Factory;

use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetOnlinebanktransferConfigInterface;

/**
 * Novalnet payment method factory interface
 */
interface NovalnetOnlinebanktransferPaymentMethodFactoryInterface
{
    /**
     * @param NovalnetOnlinebanktransferConfigInterface $config
     *
     * @return PaymentMethodInterface
     */
    public function create(NovalnetOnlinebanktransferConfigInterface $config);
}
