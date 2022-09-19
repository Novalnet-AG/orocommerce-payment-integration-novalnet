<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetCreditCardConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\NovalnetCreditCardView;

/**
 * Novalnet payment method view factory
 */
class NovalnetCreditCardViewFactory extends NovalnetViewFactory implements NovalnetCreditCardViewFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(NovalnetCreditCardConfigInterface $config)
    {
        return new NovalnetCreditCardView(
            $this->formFactory,
            $this->novalnetHelper,
            $this->translator,
            $this->doctrine,
            $this->userLocalizationManager,
            $config
        );
    }
}
