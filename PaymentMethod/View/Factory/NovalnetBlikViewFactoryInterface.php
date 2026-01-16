<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetBlikConfigInterface;
use Oro\Bundle\PaymentBundle\Method\View\PaymentMethodViewInterface;

/**
 * Novalnet payment method view factory interface
 */
interface NovalnetBlikViewFactoryInterface
{
    /**
     * @param NovalnetBlikConfigInterface $config
     *
     * @return PaymentMethodViewInterface
     */
    public function create(NovalnetBlikConfigInterface $config);
}