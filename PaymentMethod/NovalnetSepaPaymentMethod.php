<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod;

/**
 * Direct Debit SEPA Payment Method
 * Implements Novalnet Payment Method
 */
class NovalnetSepaPaymentMethod extends NovalnetPaymentMethod
{
    /**
     * {@inheritdoc}
     */
    public function purchase($paymentTransaction)
    {
        $paymentTransaction
            ->setSuccessful(false)
            ->setActive(true);

        $order = $this->doctrineHelper->getEntity(
            $paymentTransaction->getEntityClass(),
            $paymentTransaction->getEntityIdentifier()
        );
        $novalnetResponse = [];
        if ($this->config->getSepaPaymentGuarantee() && !$this->config->getSepaForceNonGuarantee()) {
            $isGuaranteePayment = $this->novalnetHelper->checkGuaranteePayment($order, $this->config, 'novalnet_sepa');
            if (!$isGuaranteePayment) {
                $guaranteeErrorMsg = $this->novalnetHelper->getGuaranteeErrorMsg(
                    $order,
                    $this->config,
                    $this->translator,
                    'novalnet_sepa'
                );
                $novalnetResponse['status_desc'] = $guaranteeErrorMsg;
                $paymentTransaction->setResponse($novalnetResponse);
                return $novalnetResponse;
            }
        }
        $request = $this->requestStack->getCurrentRequest();
        $params = $this->novalnetHelper->getBasicParams(
            $order,
            $this->config,
            $this->router,
            $paymentTransaction,
            $request,
            $this->userLocalizationManager
        );
        $response = $this->client->send('', $this->config, $params);
        parse_str($response, $result);
        if ($result['status'] == '100' && !empty($result['url'])) {
            $novalnetResponse['purchaseRedirectUrl'] = $result['url'];
        } else {
            $paymentTransaction->setResponse($result);
        }

        return $novalnetResponse;
    }
}
