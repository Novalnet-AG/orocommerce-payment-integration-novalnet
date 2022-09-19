<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View;

use Oro\Bundle\PaymentBundle\Context\PaymentContextInterface;
use Novalnet\Bundle\NovalnetBundle\Form\Type\GuaranteedSepaFormType;

/**
 * GuaranteedSepa payment method view
 */
class NovalnetGuaranteedSepaView extends NovalnetView
{
    /**
     * {@inheritdoc}
     */
    public function getBlock()
    {
        return '_payment_methods_novalnet_guaranteed_sepa_widget';
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions(PaymentContextInterface $context)
    {

        $maskedData = [];
        $saveAccountDetails = false;

        if ($this->config->getOneclick()) {
            $saveAccountDetails = true;
            $maskedData = $this->novalnetHelper->getSavedAccountDetails(
                $this->doctrine,
                'GUARANTEED_DIRECT_DEBIT_SEPA',
                $context->getCustomerUser()->getId()
            );
        }

        $errorMsg = $this->novalnetHelper->getGuaranteeErrorMsg(
            $context,
            $this->config->getMinAmount(),
            $this->translator
        );

        $formOptions = [
            'guaranteed_sepa_error_msg' => $errorMsg,
            'masked_data' => $maskedData,
        ];

        $form = $this->formFactory->create(GuaranteedSepaFormType::class, null, $formOptions);

        return [
            'testMode' => $this->config->getTestMode(),
            'notification' => $this->config->getBuyerNotification(),
            'formView' => $form->createView(),
            'paymentMethod' => $this->config->getPaymentMethodIdentifier(),
            'maskedData' => $maskedData,
            'saveAccountDetails' => $saveAccountDetails,
            'displayLogo' => $this->config->getDisplayPaymentLogo()
        ];
    }
}
