<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetMbwayConfigInterface;
use Oro\Bundle\PaymentBundle\Method\View\PaymentMethodViewInterface;

/**
 * Novalnet payment method view factory interface
 */
interface NovalnetMbwayViewFactoryInterface
{
    /**
     * @param NovalnetMbwayConfigInterface $config
     *
     * @return PaymentMethodViewInterface
     */
    public function create(NovalnetMbwayConfigInterface $config);
}