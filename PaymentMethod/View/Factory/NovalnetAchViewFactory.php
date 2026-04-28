<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetAchConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\NovalnetAchView;

/**
 * Novalnet payment method view factory
 */
class NovalnetAchViewFactory extends NovalnetViewFactory implements NovalnetAchViewFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(NovalnetAchConfigInterface $config)
    {
        return new NovalnetAchView(
            $this->formFactory,
            $this->novalnetHelper,
            $this->translator,
            $this->doctrine,
            $this->userLocalizationManager,
            $config
        );
    }
}