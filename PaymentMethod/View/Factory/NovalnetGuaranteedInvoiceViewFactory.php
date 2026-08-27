<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetGuaranteedInvoiceConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\NovalnetGuaranteedInvoiceView;

/**
 * Novalnet payment method view factory
 */
class NovalnetGuaranteedInvoiceViewFactory extends NovalnetViewFactory implements
    NovalnetGuaranteedInvoiceViewFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(NovalnetGuaranteedInvoiceConfigInterface $config)
    {
        return new NovalnetGuaranteedInvoiceView(
            $this->formFactory,
            $this->novalnetHelper,
            $this->translator,
            $this->doctrine,
            $this->userLocalizationManager,
            $config
        );
    }
}
