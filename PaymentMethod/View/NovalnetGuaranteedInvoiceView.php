<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View;

use Oro\Bundle\PaymentBundle\Context\PaymentContextInterface;
use Novalnet\Bundle\NovalnetBundle\Form\Type\GuaranteedInvoiceFormType;

/**
 * GuaranteedInvoice payment method view
 */
class NovalnetGuaranteedInvoiceView extends NovalnetView
{
    /**
     * {@inheritdoc}
     */
    public function getBlock()
    {
        return '_payment_methods_novalnet_guaranteed_invoice_widget';
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions(PaymentContextInterface $context)
    {
        $errorMsg = $this->novalnetHelper->getGuaranteeErrorMsg(
            $context,
            $this->config->getMinAmount(),
            $this->translator
        );

        return [
            'testMode' => $this->config->getTestMode(),
            'notification' => $this->config->getBuyerNotification(),
            'paymentMethod' => $this->config->getPaymentMethodIdentifier(),
            'errorMsg' => $errorMsg,
            'displayLogo' => $this->config->getDisplayPaymentLogo()
        ];
    }
}
