<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetEpsConfigInterface;
use Oro\Bundle\PaymentBundle\Method\View\PaymentMethodViewInterface;

/**
 * Novalnet payment method view provider factory interface
 */
interface NovalnetEpsViewFactoryInterface
{
    /**
     * @param NovalnetEpsConfigInterface $config
     * @return PaymentMethodViewInterface
     */
    public function create(NovalnetEpsConfigInterface $config);
}
