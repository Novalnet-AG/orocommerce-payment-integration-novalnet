<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetTrustlyConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\NovalnetTrustlyView;

/**
 * Novalnet payment method view factory
 */
class NovalnetTrustlyViewFactory extends NovalnetViewFactory implements NovalnetTrustlyViewFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(NovalnetTrustlyConfigInterface $config)
    {
        return new NovalnetTrustlyView(
            $this->formFactory,
            $this->novalnetHelper,
            $this->translator,
            $this->doctrine,
            $this->userLocalizationManager,
            $config
        );
    }
}
