<?php

namespace Oro\Bundle\NovalnetPaymentBundle\PaymentMethod;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Oro\Bundle\OrderBundle\Entity\Order;
use Oro\Bundle\EntityBundle\ORM\DoctrineHelper;
use Symfony\Component\HttpClient\CurlHttpClient;
use Oro\Bundle\NovalnetPaymentBundle\Entity\NovalnetPaymentSettings;


class NovalnetHelper
{
	/** @var string */
	private $nnSecuredParams = array('auth_code', 'product', 'tariff', 'amount', 'test_mode');
	
	/**
	 * Generate Novalnet gateway parameters
	 * 
     * @param $order
     * @param $config
     * @param $router
     * @param $paymentTransaction
     * @return array
     */
    public function getBasicParams($order, $config, $router, $paymentTransaction) 
    {		
        $amount = sprintf('%0.2f', $order->getTotal()) * 100;
        $lang = explode('_',($order->getCustomerUser()->getWebsiteSettings($order->getCustomerUser()->getWebsite())->getLocalization()->getLanguage()->getCode()));
        $paymentAccessKey = $config->getPaymentAccessKey(); 
        $mandatoryParams = [
        'vendor' => $config->getVendorId(),
        'auth_code' => $config->getAuthcode(),
        'product' => $config->getProduct(),
        'tariff' => $config->getTariff(),
        'test_mode' => ($config->getTestMode() == '1') ? '1' : '0',
        'gender' => 'u',
        'firstname' => $order->getBillingAddress()->getFirstName(),
        'lastname' => $order->getBillingAddress()->getLastName(),
        'email' => $order->getCustomerUser()->getEmail(),
        'customer_no' => $order->getCustomerUser()->getId(),
        'street' => $order->getBillingAddress()->getstreet(),
        'search_in_street' => '1',
        'country_code' => $order->getBillingAddress()->getCountryIso2(),
        'city' => $order->getBillingAddress()->getCity(),
        'zip' => $order->getBillingAddress()->getPostalCode(),
        'lang' => strtoupper($lang[0]),
        'order_no' => $order->getId(),
        'amount' => $amount,
        'currency' => $order->getCurrency(),
        'system_name' => 'orocommerce',
        'remote_ip' => self::getIp(),
        'system_ip' => self::getIp('SERVER_ADDR'),
        'hfooter' => '1',
        'skip_cfm' => '1',
        'skip_suc' => '1',
        'thide' => '1',
        'purl' => '1',        
        'implementation' => 'ENC',
        'return_method'       => 'POST',
        'error_return_method' => 'POST',
		'return_url'          => $this->createUrl($router, 'oro_novalnet_payment_frontend_novalnet_redirect_return', $paymentTransaction->getAccessIdentifier()),
		'error_return_url'    => $this->createUrl($router, 'oro_novalnet_payment_frontend_novalnet_redirect_error', $paymentTransaction->getAccessIdentifier()),
        'uniqid' => $this->getRandomString(),
         ];
         if(!empty($config->getOnholdAmount()) && $amount >= $config->getOnholdAmount()) {
			$mandatoryParams['on_hold'] = '1';
		 }
		 $mandatoryParams['due_date'] = trim($config->getInvoiceDueDate());		 
		 $mandatoryParams['sepa_due_date'] = trim($config->getSepaDuedate());
		 $mandatoryParams['cp_due_date'] = trim($config->getSepaDuedate());
		 $mandatoryParams['cc_3d'] = trim($config->getCc3d());
		 $mandatoryParams['company'] = trim($order->getBillingAddress()->getOrganization());
         
		 $mandatoryParams = array_filter($mandatoryParams, function($value) {
			 return ($value !== '');
			 });
			 
         $this->encodeParams($mandatoryParams, $paymentAccessKey);
         $mandatoryParams['hash']           = $this->generateHash($mandatoryParams, $paymentAccessKey);
         
         return $mandatoryParams;
	}
	
	/**
	 * Make a Curl call
	 * 
     * @param $config
     * @param $parameters
     * @param $url
     * @return array
     */	
	public static function performCurlRequest($config, $parameters, $url = 'https://paygate.novalnet.de/paygate.jsp'  )
    {
        // Timeout configuration
        $gateway_timeout = !empty($config->getGatewayTimeout()) ? $config->getGatewayTimeout() : '240';
                
         // Initiate cURL
        $curl_process = curl_init($url);
        // Set cURL options
        curl_setopt($curl_process, CURLOPT_POST, 1);
        curl_setopt($curl_process, CURLOPT_POSTFIELDS, $parameters);
        curl_setopt($curl_process, CURLOPT_FOLLOWLOCATION, 0);
        curl_setopt($curl_process, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($curl_process, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl_process, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl_process, CURLOPT_TIMEOUT, $gateway_timeout);
       
        // Execute cURL
        $response_data = curl_exec($curl_process);
		$error_code    = curl_errno($curl_process);
		// Handle cURL error
        if ($error_code) {
			$error_message   = curl_error( $curl_process );
			return 'status='. $error_code .'&status_message='. $error_message;
        }
        // Close cURL
        curl_close($curl_process);
        return $response_data;
    }
    
	/**
	 * Create return and error return url
	 * 
     * @param $router
     * @param $name
     * @param $accessIdentifier
     * @return string
     */
    public function createUrl($router, $name, $accessIdentifier)
    {
            $redirect_url = $router->generate(
				$name,
                ['accessIdentifier' => $accessIdentifier],
                UrlGeneratorInterface::ABSOLUTE_URL
            );
            return $redirect_url;
            
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
     * @param $data
     * @param $key
     * @return string
     */
	public function generateHash($data, $key)
	{
		$str = '';
        $hashFields = array(
            'auth_code',
            'product',
            'tariff',
            'amount',
            'test_mode',
            'uniqid'
        );
        foreach ($hashFields as $value) {
            $str .= $data[$value];
        }
        return hash('sha256',$str.strrev($key));
	}
     
    /**
     * Encode the config parameters before transaction.
     * 
     * @param $fields
     * @param $key
     * @return array
     */
    public function encodeParams(&$fields, $key)
    {
		
        foreach ($this->nnSecuredParams as $value) {
            try {
                $fields[$value] = htmlentities(base64_encode(openssl_encrypt($fields[$value], "aes-256-cbc", $key, true, $fields['uniqid'])));
            }
            catch (\Exception $e) {
                 throw new \Exception($e->getMessage());
            }
        }
        
    }
    
    /**
     * Get the customer remote address
     * 
     * @param $type
     * @return string
     */
    public function getIp($type = 'REMOTE_ADDR')
    {
        // Check to determine the IP address type
        if ($type == 'SERVER_ADDR') {
            if (empty($_SERVER['SERVER_ADDR'])) {
                // Handled for IIS server
                $ipAddress = gethostbyname($_SERVER['SERVER_NAME']);
            } else {
                $ipAddress = $_SERVER['SERVER_ADDR'];
            }
        } else { // For remote address
            $ipAddress = $this->getRemoteAddress();
        }
        
        return (filter_var($ipAddress, FILTER_VALIDATE_IP, FILTER_FLAG_IPV6)) ? '127.0.0.1' : $ipAddress;

    }
    
    /**
     * Get the  remote address
     * 
     * @return string
     */
    private function getRemoteAddress(): string
    {
        $ipKeys = array(
            'HTTP_CLIENT_IP',
            'HTTP_X_REAL_IP',
            'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR'
        );
        foreach ($ipKeys as $key) {
            if (array_key_exists($key, $_SERVER) === true) {
                foreach (explode(',', $_SERVER[$key]) as $ip) {
                    // trim for safety measures
                    return trim($ip);
                }
            }
        }
    }
    
	/**
     * Decode the basic parameters after transaction.
     *
     * @param $data
     * @param $key
     * @param $uniqid
     * @return string
     */
    public function decodeParams($data, $key, $uniqid)
    {        
            try {
                return openssl_decrypt(base64_decode($data),"aes-256-cbc", $key, true, $uniqid);
            }
            catch (\Exception $e) {
                 throw new \Exception($e->getMessage());
            }       
    }
    
    /**
     * Save transaction details in novalnet transaction detail table
     * 
     * @param $container
     * @param $data
     */
    public function insertNovalnetTransactionTable($container, $data)
    {
		$paymentType = $data['payment_type'] == 'INVOICE_START' ? $data['invoice_type'] : $data['payment_type'];
		$novalnetConfig = $this->getNovalnetConfig($container);
		
		$data['final_testmode'] = is_numeric($data['test_mode']) ? $data['test_mode'] : $this->decodeParams($data['test_mode'], $novalnetConfig['payment_access_key'], $data['uniqid']);
		$data['final_amount'] = is_numeric($data['amount']) ?  $data['amount'] * 100 : $this->decodeParams($data['amount'], $novalnetConfig['payment_access_key'], $data['uniqid']);
		
		$connection = $container->get('oro_entity.doctrine_helper')->getEntityManager('OroNovalnetPaymentBundle:NovalnetTransactionDetails')->getConnection();
		$tid_status = isset($data['tid_status']) ? $data['tid_status'] : '0'; 
		$connection->insert(
			'oro_novalnet_payment_transaction_details',
			[
				"tid" => $data['tid'],
				"test_mode" => $data['final_testmode'],
				"gateway_status" => $tid_status,
				"payment_type" => $paymentType,
				"amount" => $data['final_amount'],
				"order_no" => $data['order_no'],
				"currency" => $data['currency'],
				"customer_no" => $data['customer_no']
			]
			);
	}
	
	/**
	 * Set Payment comments based on payment type
	 * 
     * @param $qb
     * @param $doctrineHelper
     * @param $translator
     * @param $data
     * @param $error
     */
	public function setPaymentComments($qb, $doctrineHelper, $translator, $data, $error = null) {	
		$paymentTypeVal = $data['payment_type'] == 'INVOICE_START' ? strtolower($data['invoice_type']) : strtolower($data['payment_type']);
		$paymentType = $translator->trans('oro.novalnet_payment.payment_name_'.$paymentTypeVal);
		$newLine = ' | ';
        $callbackComments  = $translator->trans('oro.novalnet_payment.payment_comment')  . $newLine;
        $callbackComments .=  $paymentType . $newLine;
        $callbackComments .=  sprintf($translator->trans('oro.novalnet_payment.transaction_id'), $data['tid']). $newLine;
        if ($data['final_testmode'] == 1) { // If test transaction
            $callbackComments .= $translator->trans('oro.novalnet_payment.test_order') . $newLine;
        }
        if($error) {
			$callbackComments .= !empty($data['status_desc']) ? $data['status_desc'] : $data['status_text'] . $newLine;  
		}
		// get payment comments
        $callbackComments .= self::prepareComments($data, $translator);
		$q = $qb->createQueryBuilder();
		$q->select('nn')
          ->from('OroOrderBundle:Order', 'nn')
          ->where('nn.id = :id')
          ->setParameter('id', $data['order_no']);
        $orderDetailsEntity = $q->getQuery()->getOneOrNullResult();
        
        $customerNotes = $orderDetailsEntity->getCustomerNotes().$callbackComments;
        
        $orderDetailsEntity->setCustomerNotes($customerNotes);
		$em = $doctrineHelper->getEntityManager('OroOrderBundle:Order');
        $em->persist($orderDetailsEntity);
        $em->flush($orderDetailsEntity);
        	
	}
	
	/**
	 * Get Novalnet vendor details
	 * 
     * @param $container
     * @return array
     */
	public function getNovalnetConfig($container)
    {
		$novalnetConfigEntity = $container->get('doctrine')->getManagerForClass('OroNovalnetPaymentBundle:NovalnetPaymentSettings')->getRepository('OroNovalnetPaymentBundle:NovalnetPaymentSettings');
        
        $service = $novalnetConfigEntity->getEnabledSettings();
       
        foreach ($service as $service) {
            $novalnetConfig =  ['payment_access_key' => $service->getPaymentAccessKey(),
								  'callback_testmode' => $service->getCallbackTestmode(),
								  'email_notification' => $service->getEmailNotification(),
								  'email_to' => $service->getEmailTo(),
								  'email_bcc' => $service->getEmailBcc()];
        }
        return $novalnetConfig;
	}
	
	
	/**
	 * Set payment status 
	 * 
     * @param $qb
     * @param $doctrineHelper
     * @param $status
     * @param $orderNo
     * @return array
     */
	public function setPaymentStatus($qb, $doctrineHelper, $status, $orderNo)
    {		
		$statusQueryBuilder = $qb->createQueryBuilder();
		$paymentStatusQuery = $statusQueryBuilder->select('nn')
		                  ->from('OroPaymentBundle:PaymentStatus', 'nn')
					      ->where('nn.entityIdentifier = :orderId')
					      ->setParameter('orderId', $orderNo);
		$paymentStatus = $paymentStatusQuery->getQuery()->getOneOrNullResult();
		$paymentStatus->setPaymentStatus($status);
		$em = $doctrineHelper->getEntityManager('OroPaymentBundle:PaymentStatus');
        $em->persist($paymentStatus);
        $em->flush($paymentStatus);
        
        $transactionQueryBuilder = $qb->createQueryBuilder();
		$paymentTransactionQuery = $transactionQueryBuilder->select('nn')
		                  ->from('OroPaymentBundle:PaymentTransaction', 'nn')
					      ->where('nn.entityIdentifier = :orderId')
					      ->setParameter('orderId', $orderNo);
		$paymentTransaction = $paymentTransactionQuery->getQuery()->getOneOrNullResult();
					      
        if($status == 'full') {			
			$paymentTransaction->setSuccessful(true);
			$paymentTransaction->setActive(false);
			$em = $doctrineHelper->getEntityManager('OroPaymentBundle:PaymentTransaction');
			$em->persist($paymentTransaction);
			$em->flush($paymentTransaction);
		}
        if($status == 'declined') {
			$paymentTransaction->setSuccessful(false);
			$paymentTransaction->setActive(false);
			$em = $doctrineHelper->getEntityManager('OroPaymentBundle:PaymentTransaction');
			$em->persist($paymentTransaction);
			$em->flush($paymentTransaction);
		}		
		
	}
	
	/**
	 * Prepare payment status 
	 * 
     * @param $data
     * @param $paymentKey
     * @return string
     */
	public function prepareComments($data, $translator) {
		$newLine = ' | ';
		$callbackComments = '';
		if (in_array($data['payment_type'], array('GUARANTEED_DIRECT_DEBIT_SEPA', 'GUARANTEED_INVOICE'))) {
			   $callbackComments .= $translator->trans('oro.novalnet_payment.guarantee_payment').$newLine;
			   if($data['tid_status'] == '75') {
				   $callbackComments .=  $data['payment_type'] == 'GUARANTEED_INVOICE' ? $translator->trans('oro.novalnet_payment.invoice_guarantee_comment') : $translator->trans('oro.novalnet_payment.sepa_guarantee_comment');
			   }
        }
        if(in_array($data['payment_type'], array('INVOICE_START', 'GUARANTEED_INVOICE')) && in_array($data['tid_status'], array('91', '100'))) {
				$callbackComments .= $translator->trans('oro.novalnet_payment.invoice_comment'). $newLine;
				if(!empty($data['due_date'])) {
					$callbackComments .= sprintf($translator->trans('oro.novalnet_payment.invoice_duedate'), date('d.m.Y', strtotime($data['due_date']))). $newLine;
				}				
				$callbackComments .= sprintf($translator->trans('oro.novalnet_payment.invoice_account_holder'), $data['invoice_account_holder']). $newLine;
				$callbackComments .= 'IBAN:'.$data['invoice_iban']. $newLine;
				$callbackComments .= 'BIC:'.$data['invoice_bic']. $newLine;
				$callbackComments .= 'Bank:'.$data['invoice_bankname']. $newLine;
				$callbackComments .= sprintf($translator->trans('oro.novalnet_payment.amount'),$data['amount']).$data['currency']. $newLine;
				$callbackComments .= $translator->trans('oro.novalnet_payment.invoice_ref_comment'). $newLine;
				$callbackComments .= sprintf($translator->trans('oro.novalnet_payment.payment_ref'),'1'). ' '. $data['invoice_ref']. $newLine;
				$callbackComments .= sprintf($translator->trans('oro.novalnet_payment.payment_ref'),'2'). ' '. $data['tid'];
		}
		else if($data['payment_type'] == 'CASHPAYMENT') {
			if (!empty($data['cp_due_date'])) {
				$callbackComments .= sprintf($translator->trans('oro.novalnet_payment.slip_expiry_date'), date('d.m.Y', strtotime($data['cp_due_date']))) . $newLine;
			}
			$callbackComments .= $translator->trans('oro.novalnet_payment.cashpayment_store'). $newLine;
			$nearestStoreCounts = 1;
			foreach ($data as $key => $value) {
				if (strpos($key, 'nearest_store_title') !== FALSE) {
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
		}
		return $callbackComments;
	}
}
