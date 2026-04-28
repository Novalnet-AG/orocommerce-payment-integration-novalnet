<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetSepaConfigInterface;
use Oro\Bundle\PaymentBundle\Method\View\PaymentMethodViewInterface;

/**
 * Novalnet payment method view provider factory interface
 */
interface NovalnetSepaViewFactoryInterface
{
    /**
     * @param NovalnetSepaConfigInterface $config
     * @return PaymentMethodViewInterface
     */
    public function create(NovalnetSepaConfigInterface $config);
}
