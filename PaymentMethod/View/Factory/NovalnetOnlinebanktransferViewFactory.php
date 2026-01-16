<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetOnlinebanktransferConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\NovalnetOnlinebanktransferView;

/**
 * Novalnet payment method view factory
 */
class NovalnetOnlinebanktransferViewFactory extends NovalnetViewFactory implements NovalnetOnlinebanktransferViewFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(NovalnetOnlinebanktransferConfigInterface $config)
    {
        return new NovalnetOnlinebanktransferView(
            $this->formFactory,
            $this->novalnetHelper,
            $this->translator,
            $this->doctrine,
            $this->userLocalizationManager,
            $config
        );
    }
}
