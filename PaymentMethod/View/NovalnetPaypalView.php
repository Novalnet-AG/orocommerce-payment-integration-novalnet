<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View;

use Oro\Bundle\PaymentBundle\Context\PaymentContextInterface;
use Novalnet\Bundle\NovalnetBundle\Form\Type\PaypalFormType;

/**
 * PayPal payment method view
 */
class NovalnetPaypalView extends NovalnetView
{
    /**
     * {@inheritdoc}
     */
    public function getBlock()
    {
        return '_payment_methods_novalnet_paypal_widget';
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
                'PAYPAL',
                $context->getCustomerUser()->getId()
            );
        }


        $formOptions = [
            'masked_data' => $maskedData,
        ];

        $form = $this->formFactory->create(PaypalFormType::class, null, $formOptions);

        return [
            'testMode' => $this->config->getTestMode(),
            'notification' => $this->config->getBuyerNotification(),
            'formView' => $form->createView(),
            'paymentMethod' => $this->config->getPaymentMethodIdentifier(),
            'saveAccountDetails' => $saveAccountDetails,
            'maskedData' => $maskedData,
            'displayLogo' => $this->config->getDisplayPaymentLogo()
        ];
    }
}
