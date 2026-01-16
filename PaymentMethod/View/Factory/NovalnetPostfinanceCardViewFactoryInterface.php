<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPostfinanceCardConfigInterface;
use Oro\Bundle\PaymentBundle\Method\View\PaymentMethodViewInterface;

/**
 * Novalnet payment method view provider factory interface
 */
interface NovalnetPostfinanceCardViewFactoryInterface
{
    /**
     * @param NovalnetPostfinanceCardConfigInterface $config
     * @return PaymentMethodViewInterface
     */
    public function create(NovalnetPostfinanceCardConfigInterface $config);
}
