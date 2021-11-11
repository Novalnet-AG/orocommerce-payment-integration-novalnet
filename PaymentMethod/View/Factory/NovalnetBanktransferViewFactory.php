<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetBanktransferConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\NovalnetBanktransferView;

/**
 * Novalnet payment method view factory
 */
class NovalnetBanktransferViewFactory extends NovalnetViewFactory implements NovalnetBanktransferViewFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(NovalnetBanktransferConfigInterface $config)
    {
        return new NovalnetBanktransferView($this->formFactory, $config);
    }
}
