<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetBancontactConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\NovalnetBancontactView;

/**
 * Novalnet payment method view factory
 */
class NovalnetBancontactViewFactory extends NovalnetViewFactory implements NovalnetBancontactViewFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(NovalnetBancontactConfigInterface $config)
    {
        return new NovalnetBancontactView(
            $this->formFactory,
            $this->novalnetHelper,
            $this->translator,
            $this->doctrine,
            $this->userLocalizationManager,
            $config
        );
    }
}
