<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetMbwayConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\NovalnetMbwayView;

/**
 * Novalnet payment method view factory
 */
class NovalnetMbwayViewFactory extends NovalnetViewFactory implements NovalnetMbwayViewFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(NovalnetMbwayConfigInterface $config)
    {
        return new NovalnetMbwayView(
            $this->formFactory,
            $this->novalnetHelper,
            $this->translator,
            $this->doctrine,
            $this->userLocalizationManager,
            $config
        );
    }
}