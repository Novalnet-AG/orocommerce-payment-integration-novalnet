<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetBancontactConfigInterface;
use Oro\Bundle\PaymentBundle\Method\View\PaymentMethodViewInterface;

/**
 * Novalnet payment method view provider factory interface
 */
interface NovalnetBancontactViewFactoryInterface
{
    /**
     * @param NovalnetBancontactConfigInterface $config
     * @return PaymentMethodViewInterface
     */
    public function create(NovalnetBancontactConfigInterface $config);
}
