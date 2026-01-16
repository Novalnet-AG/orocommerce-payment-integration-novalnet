<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPayconiqConfigInterface;
use Oro\Bundle\PaymentBundle\Method\View\PaymentMethodViewInterface;

/**
 * Novalnet payment method view factory interface
 */
interface NovalnetPayconiqViewFactoryInterface
{
    /**
     * @param NovalnetPayconiqConfigInterface $config
     *
     * @return PaymentMethodViewInterface
     */
    public function create(NovalnetPayconiqConfigInterface $config);
}