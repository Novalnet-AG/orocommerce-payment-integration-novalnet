<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View;

use Oro\Bundle\PaymentBundle\Context\PaymentContextInterface;
use Novalnet\Bundle\NovalnetBundle\Form\Type\AchFormType;

/**
 * ACH payment method view
 */
class NovalnetAchView extends NovalnetView
{
    /**
     * {@inheritdoc}
     */
    public function getBlock()
    {
        return '_payment_methods_novalnet_ach_widget';
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions(PaymentContextInterface $context)
    {
		$maskedData = [];
        $saveAccountDetails = false;

        if ($this->config->getOneclick() && !$context->getCustomerUser()->isGuest()) {
            $maskedData = $this->novalnetHelper->getSavedAccountDetails(
                $this->doctrine,
                'DIRECT_DEBIT_ACH',
                $context->getCustomerUser()->getId()
            );
            $saveAccountDetails = true;
        }
		
		$formOptions = [
            'masked_data' => $maskedData,
        ];
        
		$form = $this->formFactory->create(AchFormType::class, null, $formOptions);
		
        return [
            'testMode' => $this->config->getTestMode(),
            'notification' => $this->config->getBuyerNotification(),
            'paymentMethod' => $this->config->getPaymentMethodIdentifier(),
            'displayLogo' => $this->config->getDisplayPaymentLogo(),
            'saveAccountDetails' => $this->config->getOneclick(),
            'formView' => $form->createView(),
            'maskedData' => $maskedData,
        ];
    }
}
