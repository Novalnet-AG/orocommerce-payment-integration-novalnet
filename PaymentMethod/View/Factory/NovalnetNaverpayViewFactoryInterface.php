<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetNaverpayConfigInterface;
use Oro\Bundle\PaymentBundle\Method\View\PaymentMethodViewInterface;

/**
 * Novalnet payment method view factory interface
 */
interface NovalnetNaverpayViewFactoryInterface
{
    /**
     * @param NovalnetNaverpayConfigInterface $config
     *
     * @return PaymentMethodViewInterface
     */
    public function create(NovalnetNaverpayConfigInterface $config);
}