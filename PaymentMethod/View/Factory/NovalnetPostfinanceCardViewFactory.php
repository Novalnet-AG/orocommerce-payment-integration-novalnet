<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetPostfinanceCardConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\NovalnetPostfinanceCardView;

/**
 * Novalnet payment method view factory
 */
class NovalnetPostfinanceCardViewFactory extends NovalnetViewFactory implements
    NovalnetPostfinanceCardViewFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(NovalnetPostfinanceCardConfigInterface $config)
    {
        return new NovalnetPostfinanceCardView(
            $this->formFactory,
            $this->novalnetHelper,
            $this->translator,
            $this->doctrine,
            $this->userLocalizationManager,
            $config
        );
    }
}
