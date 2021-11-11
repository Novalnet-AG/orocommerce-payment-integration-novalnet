<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPrepaymentConfigInterface;
use Oro\Bundle\PaymentBundle\Method\View\PaymentMethodViewInterface;

/**
 * Novalnet payment method view provider factory interface
 */
interface NovalnetPrepaymentViewFactoryInterface
{
    /**
     * @param NovalnetPrepaymentConfigInterface $config
     * @return PaymentMethodViewInterface
     */
    public function create(NovalnetPrepaymentConfigInterface $config);
}
