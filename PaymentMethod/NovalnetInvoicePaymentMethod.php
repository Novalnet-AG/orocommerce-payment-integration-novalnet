<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod;

use Oro\Bundle\PaymentBundle\Entity\PaymentTransaction;
use Oro\Bundle\PaymentBundle\Context\PaymentContextInterface;

/**
 * Invoice Payment Method
 * Implements Novalnet Payment Method
 */
class NovalnetInvoicePaymentMethod extends NovalnetPaymentMethod
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

        if (in_array('novalnet_guaranteed_invoice', $enabledPayments) && in_array($paymentCode, $enabledPayments)) {
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

        $params = $this->novalnetHelper->getBasicParams(
            $order,
            $this->config,
            $paymentTransaction,
            $this->requestStack->getCurrentRequest(),
            $this->userLocalizationManager,
            $this->router
        );

        $paymentUrl = $this->novalnetHelper->getPaymentUrl($this->config, $params['transaction']['amount']);
        $response = $this->client->send($this->config->getPaymentAccessKey(), $params, $paymentUrl);
        
        if ($response['result']['status_code'] == '100') {
            $novalnetResponse['nnSuccess'] = true;
            $this->novalnetHelper->setOrderStatus($response['transaction']['status'], $paymentTransaction);
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
