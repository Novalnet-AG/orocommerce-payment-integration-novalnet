<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetAlipayConfigInterface;
use Oro\Bundle\PaymentBundle\Method\View\PaymentMethodViewInterface;

/**
 * Novalnet payment method view provider factory interface
 */
interface NovalnetAlipayViewFactoryInterface
{
    /**
     * @param NovalnetAlipayConfigInterface $config
     * @return PaymentMethodViewInterface
     */
    public function create(NovalnetAlipayConfigInterface $config);
}
