<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetKakaopayConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\NovalnetKakaopayView;

/**
 * Novalnet payment method view factory
 */
class NovalnetKakaopayViewFactory extends NovalnetViewFactory implements NovalnetKakaopayViewFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(NovalnetKakaopayConfigInterface $config)
    {
        return new NovalnetKakaopayView(
            $this->formFactory,
            $this->novalnetHelper,
            $this->translator,
            $this->doctrine,
            $this->userLocalizationManager,
            $config
        );
    }
}