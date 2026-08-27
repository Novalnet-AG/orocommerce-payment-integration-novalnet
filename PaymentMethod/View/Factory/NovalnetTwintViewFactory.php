<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetTwintConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\NovalnetTwintView;

/**
 * Novalnet payment method view factory
 */
class NovalnetTwintViewFactory extends NovalnetViewFactory implements NovalnetTwintViewFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(NovalnetTwintConfigInterface $config)
    {
        return new NovalnetTwintView(
            $this->formFactory,
            $this->novalnetHelper,
            $this->translator,
            $this->doctrine,
            $this->userLocalizationManager,
            $config
        );
    }
}