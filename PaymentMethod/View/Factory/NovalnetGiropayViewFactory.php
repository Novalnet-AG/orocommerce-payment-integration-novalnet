<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetGiropayConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\NovalnetGiropayView;

/**
 * Novalnet payment method view factory
 */
class NovalnetGiropayViewFactory extends NovalnetViewFactory implements NovalnetGiropayViewFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(NovalnetGiropayConfigInterface $config)
    {
        return new NovalnetGiropayView(
            $this->formFactory,
            $this->novalnetHelper,
            $this->translator,
            $this->doctrine,
            $this->userLocalizationManager,
            $config
        );
    }
}
