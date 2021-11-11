<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetInvoiceConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\NovalnetInvoiceView;

/**
 * Novalnet payment method view factory
 */
class NovalnetInvoiceViewFactory extends NovalnetViewFactory implements NovalnetInvoiceViewFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(NovalnetInvoiceConfigInterface $config)
    {
        return new NovalnetInvoiceView($this->formFactory, $config);
    }
}
