<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetNaverpayConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\NovalnetNaverpayView;

/**
 * Novalnet payment method view factory
 */
class NovalnetNaverpayViewFactory extends NovalnetViewFactory implements NovalnetNaverpayViewFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(NovalnetNaverpayConfigInterface $config)
    {
        return new NovalnetNaverpayView(
            $this->formFactory,
            $this->novalnetHelper,
            $this->translator,
            $this->doctrine,
            $this->userLocalizationManager,
            $config
        );
    }
}