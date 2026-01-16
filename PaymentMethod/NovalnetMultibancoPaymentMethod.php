<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod;

use Oro\Bundle\PaymentBundle\Entity\PaymentTransaction;
use Oro\Bundle\PaymentBundle\Context\PaymentContextInterface;

/**
 * Multibanco Payment Method
 * Implements Novalnet Payment Method
 */
class NovalnetMultibancoPaymentMethod extends NovalnetPaymentMethod
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

        $this->novalnetHelper->getRedirectParams($params, $this->router, $paymentTransaction);

        $response = $this->client->send(
            $this->config->getPaymentAccessKey(),
            $params,
            'https://payport.novalnet.de/v2/payment'
        );

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
