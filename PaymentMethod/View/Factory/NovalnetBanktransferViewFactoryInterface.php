<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetBanktransferConfigInterface;
use Oro\Bundle\PaymentBundle\Method\View\PaymentMethodViewInterface;

/**
 * Novalnet payment method view provider factory interface
 */
interface NovalnetBanktransferViewFactoryInterface
{
    /**
     * @param NovalnetBanktransferConfigInterface $config
     * @return PaymentMethodViewInterface
     */
    public function create(NovalnetBanktransferConfigInterface $config);
}
