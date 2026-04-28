<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetGuaranteedSepaConfigInterface;
use Oro\Bundle\PaymentBundle\Method\View\PaymentMethodViewInterface;

/**
 * Novalnet payment method view provider factory interface
 */
interface NovalnetGuaranteedSepaViewFactoryInterface
{
    /**
     * @param NovalnetGuaranteedSepaConfigInterface $config
     * @return PaymentMethodViewInterface
     */
    public function create(NovalnetGuaranteedSepaConfigInterface $config);
}
