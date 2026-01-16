<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPostfinanceConfigInterface;
use Oro\Bundle\PaymentBundle\Method\View\PaymentMethodViewInterface;

/**
 * Novalnet payment method view provider factory interface
 */
interface NovalnetPostfinanceViewFactoryInterface
{
    /**
     * @param NovalnetPostfinanceConfigInterface $config
     * @return PaymentMethodViewInterface
     */
    public function create(NovalnetPostfinanceConfigInterface $config);
}
