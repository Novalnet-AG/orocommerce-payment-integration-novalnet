<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetInstalmentSepaConfigInterface;
use Oro\Bundle\PaymentBundle\Method\View\PaymentMethodViewInterface;

/**
 * Novalnet payment method view provider factory interface
 */
interface NovalnetInstalmentSepaViewFactoryInterface
{
    /**
     * @param NovalnetInstalmentSepaConfigInterface $config
     * @return PaymentMethodViewInterface
     */
    public function create(NovalnetInstalmentSepaConfigInterface $config);
}
