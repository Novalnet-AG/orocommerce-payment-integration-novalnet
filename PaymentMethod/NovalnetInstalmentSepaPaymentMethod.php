<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod;

use Oro\Bundle\PaymentBundle\Entity\PaymentTransaction;
use Oro\Bundle\PaymentBundle\Context\PaymentContextInterface;

/**
 * InstalmentSepa Payment Method
 * Implements Novalnet Payment Method
 */
class NovalnetInstalmentSepaPaymentMethod extends NovalnetPaymentMethod
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

        
        $minAmount = $this->config->getMinAmount() ? $this->config->getMinAmount() : 1998;
        $isGuaranteedPayment = $this->novalnetHelper->checkGuaranteePayment($context, $minAmount);

        if (!$isGuaranteedPayment) {
            return false;
        }

        $orderAmount = $context->getTotal() * 100;

        return $this->novalnetHelper->checkInstalment($this->config->getInstalmentCycle(), $orderAmount);
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

        $params['instalment'] = [
            'interval' => '1m',
            'cycles' => $additionalData['sepaInstalmentCycles']
        ];

        $params['customer']['billing']['company'] = $this->novalnetHelper->getCompany($order);

        if ($additionalData['instlSepaToken']) {
            $params['transaction']['payment_data'] = ['token' => $additionalData['instlSepaToken']];
        } else {
            $params['transaction']['payment_data'] = [
                'iban' => $additionalData['instlSepaIban']
            ];
            if ($additionalData['instlSepaSaveAccountDetails'] == true) {
                $params['transaction']['create_token'] = 1;
            }
        }

        $paymentTransaction->setRequest($params);
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
