<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPrepaymentConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\NovalnetPrepaymentView;

/**
 * Novalnet payment method view factory
 */
class NovalnetPrepaymentViewFactory extends NovalnetViewFactory implements NovalnetPrepaymentViewFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(NovalnetPrepaymentConfigInterface $config)
    {
        return new NovalnetPrepaymentView(
            $this->formFactory,
            $this->novalnetHelper,
            $this->translator,
            $this->doctrine,
            $this->userLocalizationManager,
            $config
        );
    }
}
