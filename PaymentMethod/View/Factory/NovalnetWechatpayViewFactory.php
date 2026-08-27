<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetWechatpayConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\NovalnetWechatpayView;

/**
 * Novalnet payment method view factory
 */
class NovalnetWechatpayViewFactory extends NovalnetViewFactory implements NovalnetWechatpayViewFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(NovalnetWechatpayConfigInterface $config)
    {
        return new NovalnetWechatpayView(
            $this->formFactory,
            $this->novalnetHelper,
            $this->translator,
            $this->doctrine,
            $this->userLocalizationManager,
            $config
        );
    }
}
