<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetCreditCardConfigInterface;
use Oro\Bundle\PaymentBundle\Method\View\PaymentMethodViewInterface;

/**
 * Novalnet payment method view provider factory interface
 */
interface NovalnetCreditCardViewFactoryInterface
{
    /**
     * @param NovalnetCreditCardConfigInterface $config
     * @return PaymentMethodViewInterface
     */
    public function create(NovalnetCreditCardConfigInterface $config);
}
