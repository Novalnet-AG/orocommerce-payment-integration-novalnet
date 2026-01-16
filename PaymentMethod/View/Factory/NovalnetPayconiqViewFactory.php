<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPayconiqConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\NovalnetPayconiqView;

/**
 * Novalnet payment method view factory
 */
class NovalnetPayconiqViewFactory extends NovalnetViewFactory implements NovalnetPayconiqViewFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(NovalnetPayconiqConfigInterface $config)
    {
        return new NovalnetPayconiqView(
            $this->formFactory,
            $this->novalnetHelper,
            $this->translator,
            $this->doctrine,
            $this->userLocalizationManager,
            $config
        );
    }
}