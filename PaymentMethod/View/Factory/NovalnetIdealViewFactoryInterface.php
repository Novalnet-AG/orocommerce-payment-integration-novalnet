<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetIdealConfigInterface;
use Oro\Bundle\PaymentBundle\Method\View\PaymentMethodViewInterface;

/**
 * Novalnet payment method view provider factory interface
 */
interface NovalnetIdealViewFactoryInterface
{
    /**
     * @param NovalnetIdealConfigInterface $config
     * @return PaymentMethodViewInterface
     */
    public function create(NovalnetIdealConfigInterface $config);
}
