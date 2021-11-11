<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPrzelewyConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\NovalnetPrzelewyView;

/**
 * Novalnet payment method view factory
 */
class NovalnetPrzelewyViewFactory extends NovalnetViewFactory implements NovalnetPrzelewyViewFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(NovalnetPrzelewyConfigInterface $config)
    {
        return new NovalnetPrzelewyView($this->formFactory, $config);
    }
}
