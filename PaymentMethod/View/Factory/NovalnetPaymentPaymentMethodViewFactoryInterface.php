<?php

namespace Oro\Bundle\NovalnetPaymentBundle\PaymentMethod\View\Factory;

use Oro\Bundle\NovalnetPaymentBundle\PaymentMethod\Config\NovalnetPaymentConfigInterface;
use Oro\Bundle\PaymentBundle\Method\View\PaymentMethodViewInterface;

/**
 * Factory for creating views of Novalnet payment method
 */
interface NovalnetPaymentPaymentMethodViewFactoryInterface
{
    /**
     * @param NovalnetPaymentConfigInterface $config
     * @return PaymentMethodViewInterface
     */
    public function create(NovalnetPaymentConfigInterface $config);
}
