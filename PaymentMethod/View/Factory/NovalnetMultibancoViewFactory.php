<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetMultibancoConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\NovalnetMultibancoView;

/**
 * Novalnet payment method view factory
 */
class NovalnetMultibancoViewFactory extends NovalnetViewFactory implements NovalnetMultibancoViewFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(NovalnetMultibancoConfigInterface $config)
    {
        return new NovalnetMultibancoView(
            $this->formFactory,
            $this->novalnetHelper,
            $this->translator,
            $this->doctrine,
            $this->userLocalizationManager,
            $config
        );
    }
}
