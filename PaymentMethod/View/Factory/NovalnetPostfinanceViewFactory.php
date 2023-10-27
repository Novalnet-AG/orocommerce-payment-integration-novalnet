<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPostfinanceConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\NovalnetPostfinanceView;

/**
 * Novalnet payment method view factory
 */
class NovalnetPostfinanceViewFactory extends NovalnetViewFactory implements NovalnetPostfinanceViewFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(NovalnetPostfinanceConfigInterface $config)
    {
        return new NovalnetPostfinanceView(
            $this->formFactory,
            $this->novalnetHelper,
            $this->translator,
            $this->doctrine,
            $this->userLocalizationManager,
            $config
        );
    }
}
