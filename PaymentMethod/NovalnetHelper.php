<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Oro\Bundle\OrderBundle\Entity\Order;
use Oro\Bundle\EntityBundle\ORM\DoctrineHelper;
use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetTransactionDetails;
use Symfony\Component\HttpFoundation\Request;

/**
 * Novalnet payment helper
 */
class NovalnetHelper
{
    /**
     * Generate Novalnet gateway parameters
     *
     * @param object $order
     * @param object $config
     * @param object $paymentTransaction
     * @param array $request
     * @param object $userLocalizationManager
     * @param object $router
     * @return array
     */
    public function getBasicParams($order, $config, $paymentTransaction, $request, $userLocalizationManager, $router)
    {
        $data = [];

        $data['merchant'] = [
            'signature' => $config->getProductActivationKey(),
            'tariff' => $config->getTariff()
        ];

        $lang = $userLocalizationManager->getCurrentLocalizationByCustomerUser($order->getCustomerUser())
                                        ->getLanguage()->getCode();

        $this->getCustomerParams($order, $data, $request);
        $this->getTransactionParams($order, $data, $paymentTransaction, $config, $router, $request);
        
        $data['custom'] = [
            'lang' => strtoupper($lang),
        ];
        return $data;
    }
    
    public function getCartParams($order, &$data) {
		
		$data['cart_info']['items_shipping_price'] = sprintf('%0.0f', $order->getShippingCost()->getValue() * 100);
		$data['cart_info']['items_tax_price'] = $data['transaction']['amount'];

        foreach ($order->getLineItems() as $lineItem) {
			$productDetails = [
				'name' => $lineItem->getProductName(),
				'quantity' => $lineItem->getQuantity(),
				'price' => sprintf('%0.0f', ($lineItem->getPrice()->getValue() * 100) * $lineItem->getQuantity()),
			];
			$data['cart_info']['line_items'][] = $productDetails;
		}
		
		$totalDiscountAmount = 0.0;
		$totalDiscountCount = 0;
        foreach ($order->getAppliedPromotions() as $appliedPromotion) {
            $discountAmount = 0.0;
			foreach ($appliedPromotion->getAppliedDiscounts() as $appliedDiscount) {
				$discountAmount += $appliedDiscount->getAmount();
				$totalDiscountCount++;
			}
			$totalDiscountAmount += $discountAmount;
        }
        
		if($totalDiscountAmount) {
			$data['cart_info']['line_items'][] = [
				'name' => 'Discount',
				'quantity' => $totalDiscountCount,
				'price' => sprintf('%0.0f', -1*($totalDiscountAmount * 100)),
			];
		}
	}

    /**
     * Get Transaction information
     *
     * @param $order
     * @param $data
     * @param $paymentTransaction
     * @param $config
     * @param $router
     * @return null
     */
    public function getTransactionParams($order, &$data, $paymentTransaction, $config, $router, $request)
    {
        $paymentCode = preg_replace('/_[0-9]{1,}$/', '', $paymentTransaction->getPaymentMethod());
        $amount = sprintf('%0.2f', $order->getTotal()) * 100;
        $data['transaction'] = [
            'payment_type' => $this->getPaymentType($paymentCode),
            'amount' => $amount,
            'currency' => $order->getCurrency(),
            'test_mode' => (int) $config->getTestMode(),
            'order_no' => $order->getId(),
            'hook_url' => $this->createUrl(
                $router,
                'oro_payment_callback_notify',
                ['accessIdentifier' => $paymentTransaction->getAccessIdentifier(),
                'accessToken' => $paymentTransaction->getAccessToken()]
            ),
            'system_name'    => 'orocommerce',
            'system_version'    => 'NN12.0.1',
            'system_ip'      => self::getIp($request, 'SERVER_ADDR'),
        ];
        $dueDatePayments = ['novalnet_sepa', 'novalnet_invoice',
        'novalnet_instalment_sepa', 'novalnet_guaranteed_sepa', 'novalnet_prepayment', 'novalnet_cashpayment'];
        
        if (in_array($paymentCode, $dueDatePayments) && $config->getDuedate()) {
            $data['transaction']['due_date'] = date('Y-m-d', strtotime('+' . $config->getDuedate() . 'days'));
        }
    }

    /**
     * Get end-customer informations
     *
     * @param object $order
     * @param array $data
     * @param object $request
     * @return null
     */
    public function getCustomerParams($order, &$data, $request)
    {
        $data['customer'] = [
            'first_name' => $order->getBillingAddress()->getFirstName(),
            'last_name' => $order->getBillingAddress()->getLastName(),
            'email' => $order->getCustomerUser()->getEmail(),
            'customer_no' => $order->getCustomerUser()->getId(),
            'customer_ip' => self::getIp($request)
        ];
        
        if(!empty($order->getCustomerUser()->getBirthday())) {
            $data['customer']['birth_date'] = $order->getCustomerUser()->getBirthday()->format('Y-m-d');
        }
        
        if(!empty($order->getBillingAddress()->getPhone())) {
            $data['customer']['tel'] = $order->getBillingAddress()->getPhone();
        }
        
        $data['customer']['billing'] = [
            'street' => $order->getBillingAddress()->getstreet() . $order->getBillingAddress()->getstreet2(),
            'city' => $order->getBillingAddress()->getCity(),
            'state' => $order->getBillingAddress()->getRegion()->getName(),
            'zip' => $order->getBillingAddress()->getPostalCode(),
            'country_code' => $order->getBillingAddress()->getCountryIso2()
        ];

        $data['customer']['shipping'] = [
            'street' => $order->getShippingAddress()->getstreet() . $order->getShippingAddress()->getstreet2(),
            'city' => $order->getShippingAddress()->getCity(),
            'state' => $order->getShippingAddress()->getRegion()->getName(),
            'zip' => $order->getShippingAddress()->getPostalCode(),
            'country_code' => $order->getShippingAddress()->getCountryIso2()
        ];
        
        if ($order->getShippingAddress()->getOrganization()) {
            $data['customer']['shipping']['company'] = $order->getShippingAddress()->getOrganization();
        }
        if ($order->getBillingAddress()->getOrganization()) {
            $data['customer']['billing']['company'] = $order->getBillingAddress()->getOrganization();
        }
        if ($data['customer']['billing'] == $data['customer']['shipping']) {
            $data['customer']['shipping'] = [
                'same_as_billing' => 1
            ];
        } else {
            $data['customer']['shipping']['first_name'] = $order->getShippingAddress()->getFirstName();
            $data['customer']['shipping']['last_name'] = $order->getShippingAddress()->getLastName();
            $data['customer']['shipping']['email'] = $order->getCustomerUser()->getEmail();
            $data['customer']['shipping']['tel'] = $order->getShippingAddress()->getPhone();
        }
    }


    /**
     * Get Redirect Payment Params
     *
     * @param $data
     * @param $router
     * @param $paymentTransaction
     */
    public function getRedirectParams(&$data, $router, $paymentTransaction)
    {
        $data['transaction']['return_url'] = $this->createUrl(
            $router,
            'oro_payment_callback_return',
            ['accessIdentifier' => $paymentTransaction->getAccessIdentifier()]
        );
        $data['transaction']['error_return_url'] = $this->createUrl(
            $router,
            'oro_payment_callback_error',
            ['accessIdentifier' => $paymentTransaction->getAccessIdentifier()]
        );
    }

    /**
     * Create url
     *
     * @param object $router
     * @param string $name
     * @param array $parameterAry
     * @return string
     */
    public function createUrl($router, $name, $parameterAry)
    {
        $redirectUrl = $router->generate(
            $name,
            $parameterAry,
            UrlGeneratorInterface::ABSOLUTE_URL
        );
        return $redirectUrl;
    }

    /**
     * Get the customer remote address
     *
     * @param object $request
     * @return string
     */
    public function getIp($request, $type = 'REMOTE_ADDR')
    {
        $ipAddress = $request->server->get($type);
        
        // Check for valid IP.
        if ('REMOTE_ADDR' === $type && filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) {
            $ipAddress = '127.0.0.1';
        }
        
        return $ipAddress;
    }


    /**
     * Save transaction details in novalnet transaction detail table
     *
     * @param object $doctrineHelper
     * @param array $data
     * @return null
     */
    public function insertNovalnetTransactionDetails($data, $doctrineHelper)
    {
        $em = $doctrineHelper->getEntityManager('NovalnetBundle:NovalnetTransactionDetails');
        $nnTransactionDetails = new NovalnetTransactionDetails();
        $nnTransactionDetails->setTid($data['tid']);
        $nnTransactionDetails->setTestMode($data['test_mode']);
        $nnTransactionDetails->setStatus($data['status']);
        $nnTransactionDetails->setPaymentType($data['payment_type']);
        $nnTransactionDetails->setAmount($data['amount']);
        $nnTransactionDetails->setOrderNo($data['order_no']);
        $nnTransactionDetails->setCurrency($data['currency']);
        $nnTransactionDetails->setCustomerNo($data['customer_id']);
        $nnTransactionDetails->setToken($data['token']);
        $nnTransactionDetails->setPaymentData($data['payment_data']);
        $nnTransactionDetails->setOneclick($data['oneclick']);
        $nnTransactionDetails->setAdditionalInfo($data['additional_info']);
        $nnTransactionDetails->setRefundedAmount(0);
        $em->persist($nnTransactionDetails);
        $em->flush();
    }
    
    /**
     * Complete order
     *
     * @param array $response
     * @return array
     */
    protected function getPaymentData($response)
    {
        $paymentData = [];
        if (in_array(
            $response['transaction']['payment_type'],
            ['DIRECT_DEBIT_SEPA', 'GUARANTEED_DIRECT_DEBIT_SEPA', 'INSTALMENT_DIRECT_DEBIT_SEPA']
        )) {
            $paymentData = ['iban' => $response['transaction']['payment_data']['iban']];
        } elseif ($response['transaction']['payment_type'] == 'PAYPAL'
          && $response['transaction']['status'] != 'ON_HOLD') {
            $paymentData = ['paypal_account' => $response['transaction']['payment_data']['paypal_account']];
        } elseif ($response['transaction']['payment_type'] == 'CREDITCARD') {
            $paymentData = $response['transaction']['payment_data'];
            unset($paymentData['token']);
        }
        
        return $paymentData;
    } 

    /**
     * Complete order
     *
     * @param $response
     * @param $paymentTransaction
     * @param $translator
     * @param $doctrineHelper
     * @return null
     */
    public function completeNovalnetOrder($response, $paymentTransaction, $translator, $doctrineHelper)
    {
        $request = $paymentTransaction->getRequest();
        $paymentData = [];
        $oneclick = 0;
        
        if ($request['transaction']['create_token']) {
            $paymentData = $this->getPaymentData($response);
            $oneclick = 1;
        }
        
        if(isset($response['instalment']) && $response['transaction']['status'] == 'CONFIRMED') {
            $response['instalment'][$response['instalment']['cycles_executed']] = ['tid' => $response['transaction']['tid']];
            $response['instalment']['formatted_cycle_amount'] = sprintf('%0.2f', $response['instalment']['cycle_amount']/100);
        }
        
        $transactionTableValues = [
            'tid' => $response['transaction']['tid'],
            'status' => $response['transaction']['status'],
            'test_mode' => $response['transaction']['test_mode'],
            'payment_type' => $response['transaction']['payment_type'],
            'amount' => $response['transaction']['amount'],
            'currency' => $response['transaction']['currency'],
            'customer_id' => $response['customer']['customer_no'],
            'order_no' => $response['transaction']['order_no'],
            'due_date' => $response['transaction']['due_date']
                         ? $response['transaction']['due_date'] : null,
            'token' => $response['transaction']['payment_data']['token']
                       ? $response['transaction']['payment_data']['token'] : null,
            'payment_data' => ($paymentData) ? json_encode($paymentData) : null,
            'oneclick' => $oneclick,
            'additional_info' => isset($response['instalment']) ? json_encode($response['instalment']) : null,
        ];

        $this->insertNovalnetTransactionDetails($transactionTableValues, $doctrineHelper);

        $this->setPaymentComments(
            $response,
            $paymentTransaction,
            $doctrineHelper,
            $translator
        );
    }


    /**
     * Set Payment comments based on payment type
     *
     * @param $response
     * @param $paymentTransaction
     * @param $doctrineHelper
     * @param $translator
     * @return null
     */
    public function setPaymentComments($response, $paymentTransaction, $doctrineHelper, $translator)
    {
        $newLine = ' | ';
        $comments = $translator->trans('novalnet.payment_comment') . $newLine;

        $comments = $translator->trans('novalnet.payment_name_' .
                    strtolower($response['transaction']['payment_type'])). $newLine;

        $comments .= $translator->trans('novalnet.transaction_id') . $response['transaction']['tid'] . $newLine;

        if ($response['transaction']['test_mode'] == 1) { // If test transaction
            $comments .= $translator->trans('novalnet.test_order') . $newLine;
        }

        // get payment comments
        $comments .= self::prepareComments($response, $translator);

        $order = $doctrineHelper->getEntity(
            $paymentTransaction->getEntityClass(),
            $paymentTransaction->getEntityIdentifier()
        );

        $this->updateOrderComments($order, $doctrineHelper, $comments);
    }


    /**
     * Update Order Comments
     *
     * @param $order
     * @param $doctrineHelper
     * @param $comments
     * @return null
     */
    public function updateOrderComments($order, $doctrineHelper, $comments)
    {
        $customerNotes = ($order->getCustomerNotes())
            ? $order->getCustomerNotes() . " | " . $comments : $comments;

        $order->setCustomerNotes($customerNotes);
        $entityManager = $doctrineHelper->getEntityManager('OroOrderBundle:Order');
        $entityManager->persist($order);
        $entityManager->flush($order);
    }

    /**
     * Prepare payment status
     *
     * @param array $data
     * @param object $translator
     * @return string
     */
    public function prepareComments($data, $translator)
    {
        $newLine = ' | ';
        $callbackComments = '';
        if (in_array($data['transaction']['payment_type'], ['GUARANTEED_DIRECT_DEBIT_SEPA', 'GUARANTEED_INVOICE', 'INSTALMENT_INVOICE', 'INSTALMENT_DIRECT_DEBIT_SEPA']) && $data['transaction']['status'] == 'PENDING') {
                $callbackComments .= in_array($data['transaction']['payment_type'], ['GUARANTEED_INVOICE', 'INSTALMENT_INVOICE'])
                    ? $translator->trans('novalnet.invoice_guarantee_comment')
                    : $translator->trans('novalnet.sepa_guarantee_comment');
        }

        if ((in_array($data['transaction']['payment_type'], ['INVOICE', 'PREPAYMENT'])
          ||  (in_array($data['transaction']['payment_type'], ['GUARANTEED_INVOICE', 'INSTALMENT_INVOICE'])
           && $data['transaction']['status'] != 'PENDING')) && isset($data['transaction']['bank_details'])) {
            self::prepareInvoiceComments($translator, $callbackComments, $data);
        } elseif ($data['transaction']['payment_type'] == 'CASHPAYMENT') {
            self::prepareCashpaymentComments($translator, $callbackComments, $data);
        } elseif ($data['transaction']['payment_type'] == 'MULTIBANCO') {
            self::prepareMultibancoComments($translator, $callbackComments, $data);
        }
        return $callbackComments;
    }



    /**
     * Prepare Invoice Payment comments
     *
     * @param object $translator
     * @param string $callbackComments
     * @param array $data
     * @return string
     */
    protected function prepareInvoiceComments($translator, &$callbackComments, $response)
    {
        $newLine = ' | ';
        $formattedAmount = $this->amountFormat($response['transaction']['amount']) . ' ' . $response['transaction']['currency'];
        $comment = sprintf($translator->trans('novalnet.amount_transfer'), $formattedAmount) . $newLine;

        if (!empty($response['transaction']['due_date']) && $response['transaction']['status'] != 'ON_HOLD') {
            $comment = sprintf($translator->trans('novalnet.amount_transfer_duedate'), $formattedAmount, date('d.m.Y', strtotime($response['transaction']['due_date']))) . $newLine;
        }
        $callbackComments .= $comment;
        $callbackComments .= sprintf(
            $translator->trans('novalnet.invoice_account_holder'),
            (isset($response['transaction']['bank_details']['account_holder'])
            ? $response['transaction']['bank_details']['account_holder'] : '')
        ) . $newLine;
        $callbackComments .= 'IBAN:' . (isset($response['transaction']['bank_details']['iban'])
                                         ? $response['transaction']['bank_details']['iban'] : '') . $newLine;
        $callbackComments .= 'BIC:' . (isset($response['transaction']['bank_details']['bic'])
                                         ? $response['transaction']['bank_details']['bic'] : '') . $newLine;
        $callbackComments .= 'Bank:' . (isset($response['transaction']['bank_details']['bank_name'])
                                          ? $response['transaction']['bank_details']['bank_name'] : '') . $newLine;
        $callbackComments .= $translator->trans('novalnet.invoice_ref_comment') . $newLine;
        $callbackComments .= sprintf($translator->trans('novalnet.payment_ref'), '1') . ' ' .
            $response['transaction']['tid'] . $newLine;
        $callbackComments .= sprintf($translator->trans('novalnet.payment_ref'), '2') . ' ' .
            (isset($response['transaction']['invoice_ref']) ? $response['transaction']['invoice_ref'] : '');
    }

    /**
     * Prepare Cashpayment comments
     *
     * @param object $translator
     * @param string $callbackComments
     * @param array $data
     * @return string
     */
    protected function prepareCashpaymentComments($translator, &$callbackComments, $response)
    {
        $newLine = ' | ';
        if (!empty($response['transaction']['due_date'])) {
            $callbackComments .= sprintf(
                $translator->trans('novalnet.slip_expiry_date'),
                date('d.m.Y', strtotime($response['transaction']['due_date']))
            ) . $newLine;
        }
        $callbackComments .= $translator->trans('novalnet.cashpayment_store') . $newLine;

        $data = json_decode(json_encode($response['transaction']['nearest_stores']), true);

        $nearestStoreCounts = count($data);

        for ($i = 1; $i <= $nearestStoreCounts; $i++) {
            $callbackComments .= $data[$i]['store_name'] . ', ';
            $callbackComments .= $data[$i]['street'] . ', ';
            $callbackComments .= $data[$i]['city'] . ', ';
            $callbackComments .= $data[$i]['zip'] . ', ';
            $callbackComments .= $data[$i]['country_code'];
            $callbackComments .= ' | ';
        }
        return $callbackComments;
    }

    /**
     * Prepare Multibanco payment comments
     *
     * @param $translator
     * @param $callbackComments
     * @param $response
     * @return null
     */
    protected function prepareMultibancoComments($translator, &$callbackComments, $response)
    {
        $newLine = ' | ';
        $callbackComments .= $translator->trans('novalnet.multibanco_comment') . $newLine;
        $callbackComments .= sprintf(
            $translator->trans('novalnet.multibanco_reference'),
            $response['transaction']['partner_payment_reference']
        ) . $newLine;
        $callbackComments .= sprintf(
            $translator->trans('novalnet.multibanco_reference_entity'),
            $response['transaction']['service_supplier_id']
        ) . $newLine;
    }

    /**
     * Check guarantee payment requirements
     * @param object $order
     * @param object $config
     * @return boolean
     */
    public function checkGuaranteePayment($order, $minAmount)
    {
        $amount = sprintf('%0.2f', $order->getTotal()) * 100;

        if ($this->isEuropeanUnionCountry($order->getBillingAddress()->getCountryIso2())
            && (self::checkShippingBillingAddress($order))
            && $amount >= $minAmount && $order->getCurrency() == 'EUR') {
            return true;
        }
        return false;
    }


    /**
     * Check european country
     *
     * @param $countryCode
     * @return bool
     */
    public function isEuropeanUnionCountry($countryCode)
    {
        $europeanUnionCountryCodes = [
            'AT', 'BE', 'BG', 'HR', 'CY', 'CZ', 'DK',
            'EE', 'FI', 'FR', 'DE', 'EL', 'HU', 'IE',
            'IT', 'LV', 'LT', 'LU', 'MT', 'NL', 'PL',
            'PT', 'RO', 'SK', 'SI', 'ES', 'SE', 'UK', 'CH'
        ];

        return in_array($countryCode, $europeanUnionCountryCodes);
    }


    /**
     * check billing shipping address
     *
     * @param $order
     * @return bool
     */
    public function checkShippingBillingAddress($order)
    {
        $billingAddress = [
            $order->getBillingAddress()->getstreet(),
            $order->getBillingAddress()->getCity(),
            $order->getBillingAddress()->getPostalCode(),
            $order->getBillingAddress()->getCountryIso2()
        ];
        $shippingAddress = [
            $order->getShippingAddress()->getstreet(),
            $order->getShippingAddress()->getCity(),
            $order->getShippingAddress()->getPostalCode(),
            $order->getShippingAddress()->getCountryIso2()
        ];

        return ($billingAddress === $shippingAddress);
    }


    /**
     * Get Guarantee Payment Error Message
     *
     * @param $order
     * @param $minAmount
     * @param $translator
     * @return string
     */
    public function getGuaranteeErrorMsg($order, $minAmount, $translator)
    {
        $guaranteeError = $translator->trans('novalnet.guarantee_error_msg') . "<br>";
        $errorMsg = '';
        $amount = sprintf('%0.2f', $order->getTotal()) * 100;

        $minAmount = ($minAmount) ? $minAmount : 999;

        if (!($amount >= $minAmount)) {
            $errorMsg .= sprintf($translator->trans('novalnet.guarantee_error_msg_amount'), $minAmount);
        }
        if (!$this->isEuropeanUnionCountry($order->getBillingAddress()->getCountryIso2())) {
            $errorMsg .= $translator->trans('novalnet.guarantee_error_msg_country');
        }
        if (!self::checkShippingBillingAddress($order)) {
            $errorMsg .= $translator->trans('novalnet.guarantee_error_msg_address');
        }
        if ($order->getCurrency() != 'EUR') {
            $errorMsg .= $translator->trans('novalnet.guarantee_error_msg_currency');
        }

        $errorMsg = $errorMsg ? $guaranteeError . $errorMsg : $errorMsg;
        return $errorMsg;
    }

    /**
     * Get Company name
     * @param object $order
     * @return string
     */
    public function getCompany($order)
    {
        $company = (trim($order->getBillingAddress()->getOrganization()))
            ? trim($order->getBillingAddress()->getOrganization())
            : ($order->getCustomerUser()->getCustomer()->getName()
            ? $order->getCustomerUser()->getCustomer()->getName() : '');
        return $company;
    }

    /**
     * Get Payment Type
     * @param $paymentCode
     * @return string
     */
    public function getPaymentType($paymentCode)
    {
        $paymentDetails = [
            'novalnet_credit_card' => 'CREDITCARD',
            'novalnet_sepa' => 'DIRECT_DEBIT_SEPA',
            'novalnet_prepayment' => 'PREPAYMENT',
            'novalnet_invoice' => 'INVOICE',
            'novalnet_banktransfer' => 'ONLINE_TRANSFER',
            'novalnet_paypal'=>  'PAYPAL',
            'novalnet_ideal' =>  'IDEAL',
            'novalnet_alipay' =>  'ALIPAY',
            'novalnet_wechatpay' =>  'WECHATPAY',
            'novalnet_onlinebanktransfer' =>  'ONLINE_BANK_TRANSFER',
            'novalnet_trustly' =>  'TRUSTLY',
            'novalnet_eps' => 'EPS',
            'novalnet_cashpayment' =>  'CASHPAYMENT',
            'novalnet_giropay' =>  'GIROPAY',
            'novalnet_przelewy' => 'PRZELEWY24',
            'novalnet_postfinance' => 'POSTFINANCE',
            'novalnet_postfinance_card' => 'POSTFINANCE_CARD',
            'novalnet_bancontact' => 'BANCONTACT',
            'novalnet_multibanco' => 'MULTIBANCO',
            'novalnet_instalment_invoice' => 'INSTALMENT_INVOICE',
            'novalnet_instalment_sepa' => 'INSTALMENT_DIRECT_DEBIT_SEPA',
            'novalnet_guaranteed_sepa' => 'GUARANTEED_DIRECT_DEBIT_SEPA',
            'novalnet_guaranteed_invoice' => 'GUARANTEED_INVOICE',
        ];

        return $paymentDetails[$paymentCode];
    }

    /**
     * Check instalment payment conditions
     *
     * @param $cycles
     * @param $orderAmount
     * @return bool
     */
    public function checkInstalment($cycles, $orderAmount)
    {
		if(!empty($cycles)) {
			$cycles = json_decode($cycles[0]);
			$min = min(array_values($cycles));
			$instalmentAmount = $orderAmount / $min;
			if (($instalmentAmount) >= 999) {
				return true;
			}
		}
		return false;
    }

    /**
     * Get Addition Payment Data(payment form data)
     *
     * @param $paymentTransaction
     * @return mixed
     * @throws \ErrorException
     * @throws \LogicException
     */
    public function getAdditionalPaymentData($paymentTransaction)
    {
        $transactionOptions = $paymentTransaction->getTransactionOptions();

        if (!array_key_exists('additionalData', $transactionOptions)) {
            throw new \ErrorException('Additional data was not found in transaction options');
        }

        $additionalData = json_decode($transactionOptions['additionalData'], true);
        if (!is_array($additionalData)) {
            throw new \LogicException('Additional data could not be decoded');
        }

        return $additionalData;
    }

    /**
     * Get Enabled payments
     *
     * @param $paymentMethodProvider
     * @param $context
     * @return array
     */
    public function getEnabledPayments($paymentMethodProvider, $context)
    {
        $paymentMethodsConfigsRules = $paymentMethodProvider
            ->getPaymentMethodsConfigsRules($context);

        $paymentMethods = [[]];
        foreach ($paymentMethodsConfigsRules as $paymentMethodsConfigsRule) {
            $paymentCodes = [];

            foreach ($paymentMethodsConfigsRule->getMethodConfigs() as $methodConfig) {
                $paymentCode = preg_replace('/_[0-9]{1,}$/', '', $methodConfig->getType());
                $paymentCodes[] = $paymentCode;
            }
            $paymentMethods[] = $paymentCodes;
        }
        return array_merge(...$paymentMethods);
    }

    /**
     * Get Novalnet Payport Url
     *
     * @param $config
     * @param $orderAmount
     * @return string
     */
    public function getPaymentUrl($config, $orderAmount)
    {
        $minAmount = $config->getOnholdAmount();
        if ($config->getPaymentAction() == 'authorize' && ($orderAmount >= $minAmount || empty($minAmount))) {
            return "https://payport.novalnet.de/v2/authorize";
        }
        return "https://payport.novalnet.de/v2/payment";
    }

    /**
     * Get saved payment details
     *
     * @param $doctrine
     * @param $paymentType
     * @param $customerId
     * @return array
     */
    public function getSavedAccountDetails($doctrine, $paymentType, $customerId)
    {
        $repository = $doctrine->getRepository(NovalnetTransactionDetails::class);
        $status = ['ON_HOLD', 'PENDING', 'DEACTIVATED', 'CONFIRMED'];

        if ($paymentType == 'PAYPAL') {
            unset($status[0]);
        }

        $qryBuilder = $repository->createQueryBuilder('nn')
            ->select('nn.id, nn.token, nn.paymentData')
            ->where('nn.customerNo = :customer_no')
            ->andWhere('nn.paymentType = :payment_type')
            ->andWhere('nn.token IS NOT NULL')
            ->andWhere('nn.status IN (:status)')
            ->andWhere('nn.paymentData IS NOT NULL')
            ->andWhere('nn.oneclick = :oneclick')
            ->setParameter('customer_no', (string) $customerId)
            ->setParameter('payment_type', $paymentType)
            ->setParameter('status', $status)
            ->setParameter('oneclick', true)
            ->orderBy('nn.id', 'DESC');
            
        $accountDetails = $qryBuilder->getQuery()->getArrayResult();

        $maskedData = [];
        $paymentData = [];
        foreach ($accountDetails as $key => $value) {
            
            if(in_array($accountDetails[$key]['paymentData'], $paymentData)) {
                continue;
            }
            
            $maskedData[]  = array_merge(['id' => $accountDetails[$key]['id'],
                                     'token' => $accountDetails[$key]['token']], (array) json_decode($accountDetails[$key]['paymentData']));
            array_push($paymentData, $accountDetails[$key]['paymentData']);
            
        } 
        return $maskedData;
    }

    /**
     * Set order status
     *
     * @param $status
     * @param $paymentTransaction
     * @return null
     */
    public function setOrderStatus($status, $paymentTransaction)
    {
        if ($status == 'CONFIRMED') {
            $paymentTransaction
            ->setSuccessful(true)
            ->setActive(false);
        } elseif (in_array($status, ['DEACTIVATED', 'FAILURE'])) {
            $paymentTransaction
            ->setSuccessful(false)
            ->setActive(false);
        }
    }

    /**
     * Convert amount format
     *
     * @param $amount
     * @return int
     */
    public function amountFormat($amount)
    {
        return sprintf('%0.2f', ( $amount / 100 ));
    }

    /**
     * Check merchant details
     *
     * @param $config
     * @return bool
     */
    public function checkMerchantData($config)
    {
        return (!empty($config->getProductActivationKey()) && !empty($config->getPaymentAccessKey()));
    }
}
