<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod\View;

use Oro\Bundle\PaymentBundle\Context\PaymentContextInterface;
use Novalnet\Bundle\NovalnetBundle\Form\Type\CreditCardFormType;

/**
 * Credit Card payment method view
 */
class NovalnetCreditCardView extends NovalnetView
{
    /**
     * {@inheritdoc}
     */
    public function getBlock()
    {
        return '_payment_methods_novalnet_credit_card_widget';
    }

    /**
     * {@inheritdoc}
     */
    public function getOptions(PaymentContextInterface $context)
    {
        $maskedData = [];
        $saveCardDetails = false;
        if ($this->config->getOneclick()) {
            $maskedData = $this->novalnetHelper->getSavedAccountDetails(
                $this->doctrine,
                'CREDITCARD',
                $context->getCustomerUser()->getId()
            );
            $saveCardDetails = true;
        }

        $formOptions = [
            'masked_data' => $maskedData,
            'enforce_3d' => $this->config->getCcEnforce3d(),
            'client_key' => $this->config->getClientKey(),
            'customer_details' => $this->getCustomerDetails($context),
            'label_style' => $this->config->getLabelStyle(),
            'input_style' => $this->config->getInputStyle(),
            'container_style' => $this->config->getContainerStyle(),
            'inline_form' => (int) $this->config->getInlineForm(),
        ];

        $form = $this->formFactory->create(CreditCardFormType::class, null, $formOptions);

        return [
            'paymentMethod' => $this->config->getPaymentMethodIdentifier(),
            'formView' => $form->createView(),
            'testMode' => $this->config->getTestMode(),
            'notification' => $this->config->getBuyerNotification(),
            'novalnetCheckoutJs' => 'https://cdn.novalnet.de/js/v2/NovalnetUtility.js',
            'maskedData' => $maskedData,
            'saveCardDetails' => $saveCardDetails,
            'displayLogo' => $this->config->getDisplayPaymentLogo(),
            'enabledLogos' => $this->config->getCreditCardLogo(),
        ];
    }


    public function getCustomerDetails(PaymentContextInterface $context)
    {
        $sameAsBilling = $this->novalnetHelper->checkShippingBillingAddress($context);

        $customerDetails = [
            'first_name' => $context->getBillingAddress()->getFirstName(),
            'last_name' => $context->getBillingAddress()->getLastName(),
            'email' => $context->getCustomerUser()->getEmail(),
            'street' => $context->getBillingAddress()->getstreet(),
            'city' => $context->getBillingAddress()->getCity(),
            'zip' => $context->getBillingAddress()->getPostalCode(),
            'country_code' => $context->getBillingAddress()->getCountryIso2(),
            'same_as_billing' => (int) $sameAsBilling,
            'amount' => sprintf('%0.2f', $context->getTotal()) * 100,
            'currency' => $context->getCurrency(),
            'test_mode' => $this->config->getTestMode(),
            'lang' => strtoupper($this->userLocalizationManager
                                        ->getCurrentLocalizationByCustomerUser($context->getCustomerUser())
                                        ->getLanguage()->getCode()),
        ];

        return json_encode($customerDetails);
    }
}
