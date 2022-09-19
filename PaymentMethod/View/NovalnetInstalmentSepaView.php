<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View;

use Oro\Bundle\PaymentBundle\Context\PaymentContextInterface;
use Novalnet\Bundle\NovalnetBundle\Form\Type\InstalmentSepaCycleType;

/**
 * InstalmentSepa payment method view
 */
class NovalnetInstalmentSepaView extends NovalnetView
{
    /**
     * {@inheritdoc}
     */
    public function getBlock()
    {
        return '_payment_methods_novalnet_instalment_sepa_widget';
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
                'INSTALMENT_DIRECT_DEBIT_SEPA',
                $context->getCustomerUser()->getId()
            );
        }

        $orderAmount = $context->getTotal() * 100;

        $instalmentDetails = $this->getInstalmentDetails($orderAmount);

        $formOptions = [
        'instalment_sepa_cycles' => $instalmentDetails,
        'masked_data' => $maskedData
        ];
        $form = $this->formFactory->create(InstalmentSepaCycleType::class, null, $formOptions);

        return [
            'testMode' => $this->config->getTestMode(),
            'notification' => $this->config->getBuyerNotification(),
            'cycleDetails' => $instalmentDetails['tableData'],
            'formView' => $form->createView(),
            'paymentMethod' => $this->config->getPaymentMethodIdentifier(),
            'saveAccountDetails' => $saveAccountDetails,
            'maskedData' => $maskedData,
            'displayLogo' => $this->config->getDisplayPaymentLogo()
        ];
    }
}
