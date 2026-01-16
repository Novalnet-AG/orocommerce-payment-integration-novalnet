<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetTwintConfigInterface;
use Oro\Bundle\PaymentBundle\Method\View\PaymentMethodViewInterface;

/**
 * Novalnet payment method view factory interface
 */
interface NovalnetTwintViewFactoryInterface
{
    /**
     * @param NovalnetTwintConfigInterface $config
     *
     * @return PaymentMethodViewInterface
     */
    public function create(NovalnetTwintConfigInterface $config);
}