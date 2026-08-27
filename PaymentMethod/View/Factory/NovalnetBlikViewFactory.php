<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetBlikConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\NovalnetBlikView;

/**
 * Novalnet payment method view factory
 */
class NovalnetBlikViewFactory extends NovalnetViewFactory implements NovalnetBlikViewFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(NovalnetBlikConfigInterface $config)
    {
        return new NovalnetBlikView(
            $this->formFactory,
            $this->novalnetHelper,
            $this->translator,
            $this->doctrine,
            $this->userLocalizationManager,
            $config
        );
    }
}