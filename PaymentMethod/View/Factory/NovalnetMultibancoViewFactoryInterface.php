<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetMultibancoConfigInterface;
use Oro\Bundle\PaymentBundle\Method\View\PaymentMethodViewInterface;

/**
 * Novalnet payment method view provider factory interface
 */
interface NovalnetMultibancoViewFactoryInterface
{
    /**
     * @param NovalnetMultibancoConfigInterface $config
     * @return PaymentMethodViewInterface
     */
    public function create(NovalnetMultibancoConfigInterface $config);
}
