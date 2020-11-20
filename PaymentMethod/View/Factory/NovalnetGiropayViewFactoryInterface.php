<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetGiropayConfigInterface;
use Oro\Bundle\PaymentBundle\Method\View\PaymentMethodViewInterface;

/**
 * Novalnet payment method view provider factory interface
 */
interface NovalnetGiropayViewFactoryInterface
{
    /**
     * @param NovalnetGiropayConfigInterface $config
     * @return PaymentMethodViewInterface
     */
    public function create(NovalnetGiropayConfigInterface $config);
}
