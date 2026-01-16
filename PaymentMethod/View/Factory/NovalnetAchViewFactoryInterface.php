<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetAchConfigInterface;
use Oro\Bundle\PaymentBundle\Method\View\PaymentMethodViewInterface;

/**
 * Novalnet payment method view factory interface
 */
interface NovalnetAchViewFactoryInterface
{
    /**
     * @param NovalnetAchConfigInterface $config
     *
     * @return PaymentMethodViewInterface
     */
    public function create(NovalnetAchConfigInterface $config);
}