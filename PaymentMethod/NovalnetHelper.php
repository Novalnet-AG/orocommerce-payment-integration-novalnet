<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod;

use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Oro\Bundle\OrderBundle\Entity\Order;
use Oro\Bundle\EntityBundle\ORM\DoctrineHelper;
use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetSettings;
use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetTransactionDetails;
use Symfony\Component\HttpFoundation\Request;

/**
 * Novalnet payment helper
 */
class NovalnetHelper
{
    /** @var string */
    private $nnSecuredParams = ['auth_code', 'product', 'tariff', 'amount', 'test_mode'];

    /**
     * Generate Novalnet gateway parameters
     *
     * @param object $order
     * @param object $config
     * @param object $router
     * @param object $paymentTransaction
     * @param array $request
     * @param object $userLocalizationManager
     * @return array
     * @throws \Exception
     */
    public function getBasicParams($order, $config, $router, $paymentTransaction, $request, $userLocalizationManager)
    {
        $paygateParams = [];

        $this->getVendorParams($config, $paygateParams);
        $this->getBillingParams($order, $paygateParams);
        $this->getCommonParams(
            $order,
            $router,
            $paymentTransaction,
            $request,
            $userLocalizationManager,
            $paygateParams
        );
        $this->getPaymentParams($order, $config, $paygateParams);
        $this->getSeamlessFormParams($paygateParams);

        $paygateParams = array_filter($paygateParams, function ($value) {
            return ($value !== '');
        });
        $this->encodeParams($paygateParams, $config->getPaymentAccessKey());
        $paygateParams['hash'] = $this->generateHash($paygateParams, $config->getPaymentAccessKey());
        return $paygateParams;
    }

    /**
     * Assign Novalnet authentication Data
     *
     * @param object $config
     * @param array $paygateParams
     * @return null
     */
    public function getVendorParams($config, &$paygateParams)
    {
        $paygateParams['vendor'] = $config->getVendorId();
        $paygateParams['auth_code'] = $config->getAuthcode();
        $paygateParams['product'] = $config->getProduct();
        $paygateParams['tariff'] = $config->getTariff();
        $paygateParams['test_mode'] = ($config->getTestMode() == '1') ? '1' : '0';
    }

    /**
     * Get end-customer billing informations
     *
     * @param object $order
     * @param array $paygateParams
     * @return null
     */
    public function getBillingParams($order, &$paygateParams)
    {
        $paygateParams['gender'] = 'u';
        $paygateParams['firstname'] = $order->getBillingAddress()->getFirstName();
        $paygateParams['lastname'] = $order->getBillingAddress()->getLastName();
        $paygateParams['email'] = $order->getCustomerUser()->getEmail();
        $paygateParams['customer_no'] = $order->getCustomerUser()->getId();
        $paygateParams['street'] = $order->getBillingAddress()->getstreet();
        $paygateParams['search_in_street'] = '1';
        $paygateParams['country_code'] = $order->getBillingAddress()->getCountryIso2();
        $paygateParams['city'] = $order->getBillingAddress()->getCity();
        $paygateParams['zip'] = $order->getBillingAddress()->getPostalCode();
        $paygateParams['tel'] = $order->getBillingAddress()->getPhone();
        $paygateParams['company'] = $this->getCompany($order);
        $paygateParams['birth_date'] = (!empty($order->getCustomerUser()->getBirthday()))
            ? trim($order->getCustomerUser()->getBirthday()->format('Y-m-d'))
            : '';
    }

    /**
     * Get common params for Novalnet payment API request
     *
     * @param object $order
     * @param object $router
     * @param object $paymentTransaction
     * @param object $request
     * @param object $userLocalizationManager
     * @param array $paygateParams
     * @return null
     */
    public function getCommonParams($order, $router, $paymentTransaction, $request, $userLocalizationManager, &$paygateParams)
    {
        $lang = $userLocalizationManager->getCurrentLocalizationByCustomerUser($order->getCustomerUser())->getLanguage()->getCode();
        $amount = sprintf('%0.2f', $order->getTotal()) * 100;
        $paygateParams['amount'] = $amount;
        $paygateParams['currency'] = $order->getCurrency();
        $paygateParams['lang'] = strtoupper($lang);
        $paygateParams['order_no'] = $order->getId();
        $paygateParams['system_name'] = 'orocommerce';
        $paygateParams['remote_ip'] = self::getIp($request);
        $paygateParams['system_ip'] = self::getIp($request, 'SERVER_ADDR');
        $paygateParams['uniqid'] = $this->getRandomString();
        $paygateParams['implementation'] = 'ENC';
        $paygateParams['return_method'] = 'POST';
        $paygateParams['error_return_method'] = 'POST';
        $paygateParams['return_url'] = $this->createUrl(
            $router,
            'oro_payment_callback_return',
            ['accessIdentifier' => $paymentTransaction->getAccessIdentifier()]
        );
        $paygateParams['error_return_url'] = $this->createUrl(
            $router,
            'oro_payment_callback_error',
            ['accessIdentifier' => $paymentTransaction->getAccessIdentifier()]
        );
        $paygateParams['hook_url'] = $this->createUrl(
            $router,
            'oro_payment_callback_notify',
            ['accessIdentifier' => $paymentTransaction->getAccessIdentifier(),
                'accessToken' => $paymentTransaction->getAccessToken()]
        );
    }

    /**
     * Assign Novalnet payment data
     *
     * @param object $order
     * @param object $config
     * @param array $paygateParams
     * @return null
     */
    public function getPaymentParams($order, $config, &$paygateParams)
    {
        $paymentCode = preg_replace('/_[0-9]{1,}$/', '', $config->getPaymentMethodIdentifier());

        $paymentId = $this->getPaymentId($paymentCode);
        $paygateParams['key'] = $paymentId;

        $paymentType = $this->getPaymentType($paymentCode);
        $paygateParams['payment_type'] = $paymentType;

        $paygateParams['referrer_id'] = trim($config->getReferrerId());

        switch ($paymentCode) {
            case 'novalnet_credit_card':
                if (!empty($config->getOnholdAmount()) && $paygateParams['amount'] >= $config->getOnholdAmount()) {
                    $paygateParams['on_hold'] = '1';
                }
                $paygateParams['cc_3d'] = trim($config->getCc3d());
                break;
            case 'novalnet_sepa':
                if (!empty($config->getOnholdAmount()) && $paygateParams['amount'] >= $config->getOnholdAmount()) {
                    $paygateParams['on_hold'] = '1';
                }
                if ($config->getSepaPaymentGuarantee()) {
                    $isGuaranteePayment = $this->checkGuaranteePayment($order, $config, 'novalnet_sepa');
                    if ($isGuaranteePayment) {
                        $paygateParams['key'] = '40';
                        $paygateParams['payment_type'] = 'GUARANTEED_DIRECT_DEBIT_SEPA';
                    }
                }
                $paygateParams['sepa_due_date'] = (trim($config->getSepaDuedate()))
                    ? date('Y-m-d', strtotime('+' . trim($config->getSepaDuedate()) . ' days')) : '';
                break;
            case 'novalnet_invoice':
                if (!empty($config->getOnholdAmount()) && $paygateParams['amount'] >= $config->getOnholdAmount()) {
                    $paygateParams['on_hold'] = '1';
                }
                $paygateParams['invoice_type'] = 'INVOICE';
                if ($config->getInvoicePaymentGuarantee()) {
                    $isGuaranteePayment = $this->checkGuaranteePayment($order, $config, 'novalnet_invoice');
                    if ($isGuaranteePayment) {
                        $paygateParams['key'] = '41';
                        $paygateParams['payment_type'] = 'GUARANTEED_INVOICE';
                        unset($paygateParams['invoice_type']);
                    }
                }
                $paygateParams['due_date'] = (trim($config->getInvoiceDueDate())) ? (trim($config->getInvoiceDueDate())) : '';
                break;
            case 'novalnet_prepayment':
                $paygateParams['invoice_type'] = 'PREPAYMENT';
                break;
            case 'novalnet_cashpayment':
                $paygateParams['cp_due_date'] = (trim($config->getCashpaymentDuedate()))
                    ? date('Y-m-d', strtotime('+' . trim($config->getCashpaymentDuedate()) . ' days')) : '';
                break;
            case 'novalnet_paypal':
                if (!empty($config->getOnholdAmount()) && $paygateParams['amount'] >= $config->getOnholdAmount()) {
                    $paygateParams['on_hold'] = '1';
                }
                break;
        }
    }

    /**
     * Get Seamless payment form customization params
     *
     * @param array $paygateParams
     * @return null
     */
    public function getSeamlessFormParams(&$paygateParams)
    {
        $paygateParams['hfooter'] = '0';
        $paygateParams['skip_cfm'] = '1';
        $paygateParams['skip_suc'] = '1';
        $paygateParams['skip_sp'] = '1';
        $paygateParams['thide'] = '1';
        $paygateParams['purl'] = '1';
        $paygateParams['address_form'] = '0';
        $paygateParams['shide'] = '1';
        $paygateParams['lhide'] = '1';
        $paygateParams['chosen_only'] = '1';
    }

    /**
     * Create return and error return url
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
     * Generate unique string.
     *
     * @return string
     */
    public function getRandomString()
    {
        $randomwordarray = explode(',', '8,7,6,5,4,3,2,1,9,0,9,7,6,1,2,3,4,5,6,7,8,9,0');
        shuffle($randomwordarray);
        return substr(implode($randomwordarray, ''), 0, 16);
    }

    /**
     * Generate the 32 digit hash code
     *
     * @param array $data
     * @param string $key
     * @return string
     */
    public function generateHash($data, $key)
    {
        $str = '';
        $hashFields = [
            'auth_code',
            'product',
            'tariff',
            'amount',
            'test_mode',
            'uniqid'
        ];
        foreach ($hashFields as $value) {
            $str .= $data[$value];
        }
        return hash('sha256', $str . strrev($key));
    }

    /**
     * Encode the config parameters before transaction.
     *
     * @param array $paygateParams
     * @param string $key
     * @return null
     */
    public function encodeParams(&$paygateParams, $key)
    {

        foreach ($this->nnSecuredParams as $value) {
            try {
                $paygateParams[$value] = htmlentities(base64_encode(openssl_encrypt(
                    $paygateParams[$value],
                    "aes-256-cbc",
                    $key,
                    true,
                    $paygateParams['uniqid']
                )));
            } catch (\Exception $e) {
                throw new \Exception($e->getMessage());
            }
        }
    }

    /**
     * Get the customer remote address
     *
     * @param object $request
     * @param string $type
     * @return string
     */
    public function getIp($request, $type = 'REMOTE_ADDR')
    {
        $ipAddress = $request->server->get($type);
        return (filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) ? '127.0.0.1' : $ipAddress;
    }

    /**
     * Decode the basic parameters after transaction.
     *
     * @param string $data
     * @param string $key
     * @param string $uniqid
     * @return string
     */
    public function decodeParams($data, $key, $uniqid)
    {
        try {
            return openssl_decrypt(base64_decode($data), "aes-256-cbc", $key, true, $uniqid);
        } catch (\Exception $e) {
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Save transaction details in novalnet transaction detail table
     *
     * @param object $doctrine
     * @param object $doctrineHelper
     * @param array $data
     * @return null
     */
    public function insertNovalnetTransactionTable($doctrine, $doctrineHelper, $data)
    {
        $paymentType = $data['payment_type'] == 'INVOICE_START' ? $data['invoice_type'] : $data['payment_type'];
        $novalnetConfig = $this->getNovalnetConfig($doctrine);
        $data['final_amount'] = is_numeric($data['amount'])
            ? $data['amount'] * 100
            : ($this->decodeParams(
                $data['amount'],
                $novalnetConfig['payment_access_key'],
                $data['uniqid']
            ));
        $tidStatus = isset($data['tid_status']) ? $data['tid_status'] : '0';
        $testMode = isset($data['final_testmode']) ? $data['final_testmode'] : $data['test_mode']; 

        $em = $doctrineHelper->getEntityManager('NovalnetBundle:NovalnetTransactionDetails');
        $nnTransactionDetails = new NovalnetTransactionDetails();
        $nnTransactionDetails->setTid($data['tid']);
        $nnTransactionDetails->setTestMode($testMode);
        $nnTransactionDetails->setGatewayStatus($tidStatus);
        $nnTransactionDetails->setPaymentType($paymentType);
        $nnTransactionDetails->setAmount($data['final_amount']);
        $nnTransactionDetails->setOrderNo($data['order_no']);
        $nnTransactionDetails->setCurrency($data['currency']);
        $nnTransactionDetails->setCustomerNo($data['customer_no']);
        $em->persist($nnTransactionDetails);
        $em->flush();
    }

    /**
     * Set Payment comments based on payment type
     *
     * @param object $doctrineManager
     * @param object $doctrineHelper
     * @param object $translator
     * @param array $data
     * @param boolean $error
     * @return null
     */
    public function setPaymentComments($paymentTransaction, $doctrineHelper, $translator, $data, $error = null)
    {
		$newLine = ' | ';
        $callbackComments = $translator->trans('novalnet.payment_comment') . $newLine;
        
        if(isset($data['tid'])) {
			$paymentTypeVal = $data['payment_type'] == 'INVOICE_START'
				? strtolower($data['invoice_type'])
				: strtolower($data['payment_type']);
			$paymentType = $translator->trans('novalnet.payment_name_' . $paymentTypeVal);
			
			$callbackComments .= $paymentType . $newLine;
			$callbackComments .= sprintf(
				$translator->trans('novalnet.transaction_id'),
				$data['tid']
			) . $newLine;
			if ($data['final_testmode'] == 1) { // If test transaction
				$callbackComments .= $translator->trans('novalnet.test_order') . $newLine;
			}
			if ($error) {
				$callbackComments .= !empty($data['status_desc'])
					? $data['status_desc']
					: $data['status_text'] . $newLine;
			}
			// get payment comments
			$callbackComments .= self::prepareComments($data, $translator);
	    }
	    else {
			$callbackComments .= $data['status_desc'];
		}

        $order = $doctrineHelper->getEntity(
            $paymentTransaction->getEntityClass(),
            $paymentTransaction->getEntityIdentifier()
        );

        $customerNotes = ($order->getCustomerNotes())
            ? $order->getCustomerNotes() . " | " . $callbackComments : $callbackComments;

        $order->setCustomerNotes($customerNotes);
        $entityManager = $doctrineHelper->getEntityManager('OroOrderBundle:Order');
        $entityManager->persist($order);
        $entityManager->flush($order);
    }

    /**
     * Get Novalnet vendor details
     *
     * @param object $doctrine
     * @return array
     */
    public function getNovalnetConfig($doctrine)
    {
        $novalnetConfigEntity = $doctrine->getManagerForClass('NovalnetBundle:NovalnetSettings')
            ->getRepository('NovalnetBundle:NovalnetSettings');

        $service = $novalnetConfigEntity->getEnabledSettings();

        foreach ($service as $service) {
            $novalnetConfig = ['payment_access_key' => $service->getPaymentAccessKey(),
                'callback_testmode' => $service->getCallbackTestmode(),
                'email_notification' => $service->getEmailNotification(),
                'email_to' => $service->getEmailTo(),
                'email_bcc' => $service->getEmailBcc()];
        }
        return $novalnetConfig;
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
        if(isset($data['tid_status'])) {
			if (in_array($data['payment_type'], ['GUARANTEED_DIRECT_DEBIT_SEPA', 'GUARANTEED_INVOICE'])) {
				$callbackComments .= $translator->trans('novalnet.guarantee_payment') . $newLine;
				if ($data['tid_status'] == '75') {
					$callbackComments .= $data['payment_type'] == 'GUARANTEED_INVOICE'
						? $translator->trans('novalnet.invoice_guarantee_comment')
						: $translator->trans('novalnet.sepa_guarantee_comment');
				}
			}
			if (in_array($data['payment_type'], ['INVOICE_START', 'GUARANTEED_INVOICE'])
				&& in_array($data['tid_status'], ['91', '100'])) {
				$callbackComments = self::prepareInvoiceComments($translator, $callbackComments, $data);
			} elseif ($data['payment_type'] == 'CASHPAYMENT') {
				$callbackComments = self::prepareCashpaymentComments($translator, $callbackComments, $data);
			}
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
    protected function prepareInvoiceComments($translator, $callbackComments, $data)
    {
        $newLine = ' | ';
        $callbackComments .= $translator->trans('novalnet.invoice_comment') . $newLine;
        if (!empty($data['due_date'])) {
            $callbackComments .= sprintf(
                $translator->trans('novalnet.invoice_duedate'),
                date('d.m.Y', strtotime($data['due_date']))
            ) . $newLine;
        }
        $callbackComments .= sprintf(
            $translator->trans('novalnet.invoice_account_holder'),
            (isset($data['invoice_account_holder']) ? $data['invoice_account_holder'] : '')
        ) . $newLine;
        $callbackComments .= 'IBAN:' . (isset($data['invoice_iban']) ? $data['invoice_iban'] : '') . $newLine;
        $callbackComments .= 'BIC:' . (isset($data['invoice_bic']) ? $data['invoice_bic'] : '') . $newLine;
        $callbackComments .= 'Bank:' . (isset($data['invoice_bankname']) ? $data['invoice_bankname'] : '') . $newLine;
        $callbackComments .= sprintf(
            $translator->trans('novalnet.amount'),
            $data['amount']
        ) . $data['currency'] . $newLine;
        $callbackComments .= $translator->trans('novalnet.invoice_ref_comment') . $newLine;
        $callbackComments .= sprintf($translator->trans('novalnet.payment_ref'), '1') . ' ' .
            (isset($data['invoice_ref']) ? $data['invoice_ref'] : '') . $newLine;
        $callbackComments .= sprintf($translator->trans('novalnet.payment_ref'), '2') . ' ' .
            $data['tid'];
        return $callbackComments;
    }

    /**
     * Prepare Cashpayment comments
     *
     * @param object $translator
     * @param string $callbackComments
     * @param array $data
     * @return string
     */
    protected function prepareCashpaymentComments($translator, $callbackComments, $data)
    {
        $newLine = ' | ';
        if (!empty($data['cp_due_date'])) {
            $callbackComments .= sprintf(
                $translator->trans('novalnet.slip_expiry_date'),
                date('d.m.Y', strtotime($data['cp_due_date']))
            ) . $newLine;
        }
        $callbackComments .= $translator->trans('novalnet.cashpayment_store') . $newLine;
        $nearestStoreCounts = 1;
        foreach ($data as $key => $value) {
            if (strpos($key, 'nearest_store_title') !== false) {
                $nearestStoreCounts++;
            }
        }
        for ($i = 1; $i < $nearestStoreCounts; $i++) {
            $callbackComments .= ' | ';
            $callbackComments .= $data['nearest_store_title_' . $i] . ', ';
            $callbackComments .= $data['nearest_store_street_' . $i] . ', ';
            $callbackComments .= $data['nearest_store_city_' . $i] . ', ';
            $callbackComments .= $data['nearest_store_zipcode_' . $i] . ', ';
            $callbackComments .= $data['nearest_store_country_' . $i];
        }
        return $callbackComments;
    }

    /**
     * Get Novalnet payment method id/key
     *
     * @param string $code
     * @return string
     */
    public function getPaymentId($code)
    {
        $paymentId = [
            'novalnet_credit_card' => '6',
            'novalnet_sepa' => '37',
            'novalnet_prepayment' => '27',
            'novalnet_invoice' => '27',
            'novalnet_banktransfer' => '33',
            'novalnet_paypal' => '34',
            'novalnet_ideal' => '49',
            'novalnet_eps' => '50',
            'novalnet_cashpayment' => '59',
            'novalnet_giropay' => '69',
            'novalnet_przelewy' => '78',
        ];
        return $paymentId[$code];
    }

    /**
     * Get Novalnet payment method type
     *
     * @param string $code
     * @return string
     */
    public function getPaymentType($code)
    {
        $paymentType = [
            'novalnet_credit_card' => 'CREDITCARD',
            'novalnet_sepa' => 'DIRECT_DEBIT_SEPA',
            'novalnet_prepayment' => 'INVOICE_START',
            'novalnet_invoice' => 'INVOICE_START',
            'novalnet_banktransfer' => 'ONLINE_TRANSFER',
            'novalnet_paypal' => 'PAYPAL',
            'novalnet_ideal' => 'IDEAL',
            'novalnet_eps' => 'EPS',
            'novalnet_cashpayment' => 'CASHPAYMENT',
            'novalnet_giropay' => 'GIROPAY',
            'novalnet_przelewy' => 'PRZELEWY24',
        ];
        return $paymentType[$code];
    }

    /**
     * Check guarantee payment requirements
     * @param object $order
     * @param object $config
     * @param string $paymentType
     * @return boolean
     */
    public function checkGuaranteePayment($order, $config, $paymentType)
    {
        $amount = sprintf('%0.2f', $order->getTotal()) * 100;
        $min_amount = ($paymentType == 'novalnet_invoice')
            ? $config->getInvoiceGuaranteeMinAmount()
            : (($paymentType == 'novalnet_sepa') ? $config->getSepaGuaranteeMinAmount() : '');
        $min_amount = ($min_amount) ? $min_amount : 999;
        $billingAddress = [
            $order->getBillingAddress()->getstreet(),
            $order->getBillingAddress()->getstreet2(),
            $order->getBillingAddress()->getCity(),
            $order->getBillingAddress()->getPostalCode(),
            $order->getBillingAddress()->getCountryIso2()
        ];
        $shippingAddress = [
            $order->getShippingAddress()->getstreet(),
            $order->getShippingAddress()->getstreet2(),
            $order->getShippingAddress()->getCity(),
            $order->getShippingAddress()->getPostalCode(),
            $order->getShippingAddress()->getCountryIso2()
        ];
        $company = $this->getCompany($order);

        if (in_array($order->getBillingAddress()->getCountryIso2(), ['AT', 'CH', 'DE'])
            && ($shippingAddress === $billingAddress) && ($company)
            && $amount >= $min_amount && $order->getCurrency() == 'EUR') {
            return true;
        }
        return false;
    }

    /**
     * Get guarantee payment guarantee payment error messsage
     * @param object $order
     * @param object $config
     * @param object $translator
     * @param string $paymentType
     * @return string
     */
    public function getGuaranteeErrorMsg($order, $config, $translator, $paymentType)
    {
        $errorMsg = $translator->trans('novalnet.guarantee_error_msg') . "<br>";
        $amount = sprintf('%0.2f', $order->getTotal()) * 100;
        $min_amount = ($paymentType == 'novalnet_invoice')
            ? $config->getInvoiceGuaranteeMinAmount()
            : (($paymentType == 'novalnet_sepa') ? $config->getSepaGuaranteeMinAmount() : '');
        $billingAddress = [
            $order->getBillingAddress()->getstreet(),
            $order->getBillingAddress()->getstreet2(),
            $order->getBillingAddress()->getCity(),
            $order->getBillingAddress()->getPostalCode(),
            $order->getBillingAddress()->getCountryIso2()
        ];
        $shippingAddress = [
            $order->getShippingAddress()->getstreet(),
            $order->getShippingAddress()->getstreet2(),
            $order->getShippingAddress()->getCity(),
            $order->getShippingAddress()->getPostalCode(),
            $order->getShippingAddress()->getCountryIso2()
        ];
        $company = $this->getCompany($order);
        if (!($amount >= $min_amount)) {
            $errorMsg .= sprintf($translator->trans('novalnet.guarantee_error_msg_amount'), $min_amount);
        }
        if (!in_array($order->getBillingAddress()->getCountryIso2(), ['AT', 'CH', 'DE'])) {
            $errorMsg .= $translator->trans('novalnet.guarantee_error_msg_country');
        }
        if ($shippingAddress !== $billingAddress) {
            $errorMsg .= $translator->trans('novalnet.guarantee_error_msg_address');
        }
        if ($order->getCurrency() != 'EUR') {
            $errorMsg .= $translator->trans('novalnet.guarantee_error_msg_currency');
        }
        if (!$company) {
            $errorMsg .= $translator->trans('novalnet.guarantee_error_msg_company');
        }
        return $errorMsg;
    }

    /**
     * Get guarantee payment guarantee payment error messsage
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
}
