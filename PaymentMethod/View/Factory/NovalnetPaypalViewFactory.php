<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPaypalConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\NovalnetPaypalView;

/**
 * Novalnet payment method view factory
 */
class NovalnetPaypalViewFactory extends NovalnetViewFactory implements NovalnetPaypalViewFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(NovalnetPaypalConfigInterface $config)
    {
        return new NovalnetPaypalView(
            $this->formFactory,
            $this->novalnetHelper,
            $this->translator,
            $this->doctrine,
            $this->userLocalizationManager,
            $config
        );
    }
}
