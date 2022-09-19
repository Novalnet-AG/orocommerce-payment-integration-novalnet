<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetGuaranteedSepaConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\NovalnetGuaranteedSepaView;

/**
 * Novalnet payment method view factory
 */
class NovalnetGuaranteedSepaViewFactory extends NovalnetViewFactory implements
    NovalnetGuaranteedSepaViewFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(NovalnetGuaranteedSepaConfigInterface $config)
    {
        return new NovalnetGuaranteedSepaView(
            $this->formFactory,
            $this->novalnetHelper,
            $this->translator,
            $this->doctrine,
            $this->userLocalizationManager,
            $config
        );
    }
}
