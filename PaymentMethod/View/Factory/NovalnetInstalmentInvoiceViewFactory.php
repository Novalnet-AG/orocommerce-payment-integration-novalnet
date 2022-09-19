<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\Factory;

use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Config\NovalnetInstalmentInvoiceConfigInterface;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\View\NovalnetInstalmentInvoiceView;

/**
 * Novalnet payment method view factory
 */
class NovalnetInstalmentInvoiceViewFactory extends NovalnetViewFactory implements
    NovalnetInstalmentInvoiceViewFactoryInterface
{
    /**
     * {@inheritdoc}
     */
    public function create(NovalnetInstalmentInvoiceConfigInterface $config)
    {
        return new NovalnetInstalmentInvoiceView(
            $this->formFactory,
            $this->novalnetHelper,
            $this->translator,
            $this->doctrine,
            $this->userLocalizationManager,
            $config
        );
    }
}
