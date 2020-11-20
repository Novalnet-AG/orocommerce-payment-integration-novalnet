<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetSepaConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\NovalnetSepaView;

/**
 * Novalnet payment method view factory
 */
class NovalnetSepaViewFactory extends NovalnetViewFactory implements NovalnetSepaViewFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(NovalnetSepaConfigInterface $config)
    {
        return new NovalnetSepaView($this->formFactory, $config);
    }
}
