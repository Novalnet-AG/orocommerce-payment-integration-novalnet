<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetIdealConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\NovalnetIdealView;

/**
 * Novalnet payment method view factory
 */
class NovalnetIdealViewFactory extends NovalnetViewFactory implements NovalnetIdealViewFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(NovalnetIdealConfigInterface $config)
    {
        return new NovalnetIdealView(
            $this->formFactory,
            $this->novalnetHelper,
            $this->translator,
            $this->doctrine,
            $this->userLocalizationManager,
            $config
        );
    }
}
