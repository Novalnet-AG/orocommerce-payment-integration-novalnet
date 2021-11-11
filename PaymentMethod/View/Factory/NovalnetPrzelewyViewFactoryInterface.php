<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPrzelewyConfigInterface;
use Oro\Bundle\PaymentBundle\Method\View\PaymentMethodViewInterface;

/**
 * Novalnet payment method view provider factory interface
 */
interface NovalnetPrzelewyViewFactoryInterface
{
    /**
     * @param NovalnetPrzelewyConfigInterface $config
     * @return PaymentMethodViewInterface
     */
    public function create(NovalnetPrzelewyConfigInterface $config);
}
