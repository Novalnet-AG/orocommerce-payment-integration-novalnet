<?php

namespace Oro\Bundle\NovalnetPaymentBundle\PaymentMethod\View\Factory;

use Oro\Bundle\NovalnetPaymentBundle\PaymentMethod\Config\NovalnetPaymentConfigInterface;
use Oro\Bundle\NovalnetPaymentBundle\PaymentMethod\View\NovalnetPaymentView;

/**
 * Factory for creating views of Novalnet payment method
 */
class NovalnetPaymentPaymentMethodViewFactory implements NovalnetPaymentPaymentMethodViewFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(NovalnetPaymentConfigInterface $config)
    {
        return new NovalnetPaymentView($config);
    }
}
