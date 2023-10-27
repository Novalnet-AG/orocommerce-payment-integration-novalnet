<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetCashpaymentConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\NovalnetCashpaymentView;

/**
 * Novalnet payment method view factory
 */
class NovalnetCashpaymentViewFactory extends NovalnetViewFactory implements NovalnetCashpaymentViewFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(NovalnetCashpaymentConfigInterface $config)
    {
        return new NovalnetCashpaymentView(
            $this->formFactory,
            $this->novalnetHelper,
            $this->translator,
            $this->doctrine,
            $this->userLocalizationManager,
            $config
        );
    }
}
