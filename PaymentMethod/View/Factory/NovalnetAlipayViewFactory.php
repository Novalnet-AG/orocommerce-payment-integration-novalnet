<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetAlipayConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\NovalnetAlipayView;

/**
 * Novalnet payment method view factory
 */
class NovalnetAlipayViewFactory extends NovalnetViewFactory implements NovalnetAlipayViewFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(NovalnetAlipayConfigInterface $config)
    {
        return new NovalnetAlipayView(
            $this->formFactory,
            $this->novalnetHelper,
            $this->translator,
            $this->doctrine,
            $this->userLocalizationManager,
            $config
        );
    }
}
