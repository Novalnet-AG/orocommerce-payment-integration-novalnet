<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetCashpaymentConfigInterface;
use Oro\Bundle\PaymentBundle\Method\View\PaymentMethodViewInterface;

/**
 * Novalnet payment method view provider factory interface
 */
interface NovalnetCashpaymentViewFactoryInterface
{
    /**
     * @param NovalnetCashpaymentConfigInterface $config
     * @return PaymentMethodViewInterface
     */
    public function create(NovalnetCashpaymentConfigInterface $config);
}
