<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod;

use Oro\Bundle\PaymentBundle\Entity\PaymentTransaction;
use Oro\Bundle\PaymentBundle\Context\PaymentContextInterface;

/**
 * Credit Card Payment Method
 * Implements Novalnet Payment Method
 */
class NovalnetCreditCardPaymentMethod extends NovalnetPaymentMethod
{

    /**
     * {@inheritdoc}
     */
    public function isApplicable(PaymentContextInterface $context)
    {
        return $this->novalnetHelper->checkMerchantData($this->config);
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

        if ($additionalData['ccToken']) {
            $params['transaction']['payment_data'] = ['token' => $additionalData['ccToken']];
        } else {
            $params['transaction']['payment_data'] = [
                'pan_hash' =>  $additionalData['panHash'],
                'unique_id' => $additionalData['uniqueId']
            ];

            if ($additionalData['doRedirect'] == 1) {
                $this->novalnetHelper->getRedirectParams($params, $this->router, $paymentTransaction);

                if ($this->config->getCcEnforce3d() == true) {
                    $params['transaction']['payment_data']['enforce_3d'] = 1;
                }
            }
            if ($additionalData['saveCardDetails'] == true) {
                $params['transaction']['create_token'] = 1;
            }
        }


        $paymentUrl = $this->novalnetHelper->getPaymentUrl($this->config, $params['transaction']['amount']);

        $paymentTransaction->setRequest($params);

        $response = $this->client->send($this->config->getPaymentAccessKey(), $params, $paymentUrl);

        if ($response['result']['status_code'] == '100') {
            $novalnetResponse['nnSuccess'] = true;
            if ($response['result']['redirect_url']) {
                $novalnetResponse['nnRedirectUrl'] = $response['result']['redirect_url'];
                $paymentTransaction->setReference($response['transaction']['txn_secret']);
            } else {
                $this->novalnetHelper->setOrderStatus($response['transaction']['status'], $paymentTransaction);
                $this->novalnetHelper->completeNovalnetOrder(
                    $response,
                    $paymentTransaction,
                    $this->translator,
                    $this->doctrineHelper
                );
            }
        } else {
            $novalnetResponse['nnSuccess'] = false;
            $novalnetResponse['nnErrorMsg'] = $response['result']['status_text'];
            $paymentTransaction->setResponse($response);
        }
        return $novalnetResponse;
    }
}
