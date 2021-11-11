<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetEpsConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\NovalnetEpsView;

/**
 * Novalnet payment method view factory
 */
class NovalnetEpsViewFactory extends NovalnetViewFactory implements NovalnetEpsViewFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(NovalnetEpsConfigInterface $config)
    {
        return new NovalnetEpsView($this->formFactory, $config);
    }
}
