<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod;

use Oro\Bundle\PaymentBundle\Entity\PaymentTransaction;
use Oro\Bundle\PaymentBundle\Context\PaymentContextInterface;

/**
 * Direct Debit SEPA Payment Method
 * Implements Novalnet Payment Method
 */
class NovalnetSepaPaymentMethod extends NovalnetPaymentMethod
{
    /**
     * {@inheritdoc}
     */
    public function isApplicable(PaymentContextInterface $context)
    {
        $isValid = $this->novalnetHelper->checkMerchantData($this->config);

        if (!$isValid) {
            return false;
        }

        $enabledPayments = $this->novalnetHelper->getEnabledPayments($this->paymentMethodProvider, $context);

        $paymentCode = $this->getPaymentCode();

        if (in_array('novalnet_guaranteed_sepa', $enabledPayments) && in_array($paymentCode, $enabledPayments)) {
            $minAmount = $this->config->getMinAmount() ? $this->config->getMinAmount() : 999;
            $displayGuaranteePayment = $this->novalnetHelper->checkGuaranteePayment($context, $minAmount);
            return ($displayGuaranteePayment == true) ? false : true;
        }
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function purchase(PaymentTransaction $paymentTransaction)
    {

        $paymentTransaction
            ->setSuccessful(false)
            ->setActive(true);

        $order = $this->doctrineHelper->getEntity(
            $paymentTransaction->getEntityClass(),
            $paymentTransaction->getEntityIdentifier()
        );
        $novalnetResponse = [];


        $request = $this->requestStack->getCurrentRequest();
        $params = $this->novalnetHelper->getBasicParams(
            $order,
            $this->config,
            $paymentTransaction,
            $request,
            $this->userLocalizationManager,
            $this->router
        );


        $additionalData = $this->novalnetHelper->getAdditionalPaymentData($paymentTransaction);
        if ($additionalData['sepaToken']) {
            $params['transaction']['payment_data'] = ['token' => $additionalData['sepaToken']];
        } else {
            $params['transaction']['payment_data'] = [
                'iban' => $additionalData['sepaIban']
            ];

            if ($additionalData['sepaSaveAccountDetails'] == true) {
                $params['transaction']['create_token'] = 1;
            }
        }


        $paymentUrl = $this->novalnetHelper->getPaymentUrl($this->config, $params['transaction']['amount']);

        $paymentTransaction->setRequest($params);

        $response = $this->client->send($this->config->getPaymentAccessKey(), $params, $paymentUrl);

        if ($response['result']['status_code'] == '100') {
            $this->novalnetHelper->setOrderStatus($response['transaction']['status'], $paymentTransaction);
            $novalnetResponse['nnSuccess'] = true;
            $this->novalnetHelper->completeNovalnetOrder(
                $response,
                $paymentTransaction,
                $this->translator,
                $this->doctrineHelper
            );
        } else {
            $novalnetResponse['nnSuccess'] = false;
            $novalnetResponse['nnErrorMsg'] = $response['result']['status_text'];
            $paymentTransaction->setResponse($response);
        }
        return $novalnetResponse;
    }
}
