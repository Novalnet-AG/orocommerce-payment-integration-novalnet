<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPaypalConfigInterface;
use Oro\Bundle\PaymentBundle\Method\View\PaymentMethodViewInterface;

/**
 * Novalnet payment method view provider factory interface
 */
interface NovalnetPaypalViewFactoryInterface
{
    /**
     * @param NovalnetPaypalConfigInterface $config
     * @return PaymentMethodViewInterface
     */
    public function create(NovalnetPaypalConfigInterface $config);
}
