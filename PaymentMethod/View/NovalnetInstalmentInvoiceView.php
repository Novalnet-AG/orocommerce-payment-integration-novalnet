<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View;

use Oro\Bundle\PaymentBundle\Context\PaymentContextInterface;
use Novalnet\Bundle\NovalnetBundle\Form\Type\InstalmentInvoiceCycleType;

/**
 * InstalmentInvoice payment method view
 */
class NovalnetInstalmentInvoiceView extends NovalnetView
{
    /**
     * {@inheritdoc}
     */
    public function getBlock()
    {
        return '_payment_methods_novalnet_instalment_invoice_widget';
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions(PaymentContextInterface $context)
    {
        $orderAmount = $context->getTotal() * 100;

        $instalmentDetails = $this->getInstalmentDetails($orderAmount);

        $formOptions = [
        'instalment_invoice_cycles' => $instalmentDetails
        ];

        $form = $this->formFactory->create(InstalmentInvoiceCycleType::class, null, $formOptions);

        return [
            'testMode' => $this->config->getTestMode(),
            'cycleDetails' => $instalmentDetails['tableData'],
            'formView' => $form->createView(),
            'paymentMethod' => $this->config->getPaymentMethodIdentifier(),
            'displayLogo' => $this->config->getDisplayPaymentLogo()
        ];
    }
}
