<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetInstalmentSepaConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\NovalnetInstalmentSepaView;

/**
 * Novalnet payment method view factory
 */
class NovalnetInstalmentSepaViewFactory extends NovalnetViewFactory implements
    NovalnetInstalmentSepaViewFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(NovalnetInstalmentSepaConfigInterface $config)
    {
        return new NovalnetInstalmentSepaView(
            $this->formFactory,
            $this->novalnetHelper,
            $this->translator,
            $this->doctrine,
            $this->userLocalizationManager,
            $config
        );
    }
}
