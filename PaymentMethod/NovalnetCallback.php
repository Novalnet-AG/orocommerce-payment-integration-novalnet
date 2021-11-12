<?php

namespace Oro\Bundle\NovalnetPaymentBundle\PaymentMethod;
use Oro\Bundle\EmailBundle\Form\Model\Email;

/**
 * Novalnet Callback script
 */
class NovalnetCallback
{
    /**
     * Type of payment available - Level : 0
     *
     * @var array
     */
    private $aryPayments = array('CREDITCARD', 'INVOICE_START', 'DIRECT_DEBIT_SEPA', 'GUARANTEED_DIRECT_DEBIT_SEPA', 'GUARANTEED_INVOICE', 'PAYPAL', 'ONLINE_TRANSFER', 'IDEAL', 'EPS', 'GIROPAY', 'PRZELEWY24', 'CASHPAYMENT');

    /**
	 * Type of Chargebacks available - Level : 1
	 *
	 * @var array
	 */
    private $aryChargebacks = array('RETURN_DEBIT_SEPA', 'CREDITCARD_BOOKBACK', 'CREDITCARD_CHARGEBACK', 'REFUND_BY_BANK_TRANSFER_EU', 'PAYPAL_BOOKBACK', 'PRZELEWY24_REFUND', 'REVERSAL', 'CASHPAYMENT_REFUND','GUARANTEED_INVOICE_BOOKBACK' , 'GUARANTEED_SEPA_BOOKBACK');
    
    /**
	 * Type of Credit entry payment and Collections available - Level : 2
	 *
	 * @var array
	 */
    private $aryCollection = array('INVOICE_CREDIT', 'CREDIT_ENTRY_CREDITCARD', 'CREDIT_ENTRY_SEPA', 'DEBT_COLLECTION_SEPA', 'DEBT_COLLECTION_CREDITCARD', 'ONLINE_TRANSFER_CREDIT', 'CASHPAYMENT_CREDIT','CREDIT_ENTRY_DE','DEBT_COLLECTION_DE');

    /**
	 * Types of payment available
	 *
	 * @var array
	 */    
    private $aPaymentTypes = array(
    'CREDITCARD' => array('CREDITCARD', 'CREDITCARD_BOOKBACK', 'CREDITCARD_CHARGEBACK', 'CREDIT_ENTRY_CREDITCARD', 'SUBSCRIPTION_STOP', 'SUBSCRIPTION_REACTIVATE', 'DEBT_COLLECTION_CREDITCARD'),
    'DIRECT_DEBIT_SEPA' => array('DIRECT_DEBIT_SEPA', 'GUARANTEED_SEPA_BOOKBACK', 'RETURN_DEBIT_SEPA', 'SUBSCRIPTION_STOP', 'SUBSCRIPTION_REACTIVATE', 'DEBT_COLLECTION_SEPA', 'CREDIT_ENTRY_SEPA', 'REFUND_BY_BANK_TRANSFER_EU', 'GUARANTEED_DIRECT_DEBIT_SEPA'),
    'IDEAL' => array('IDEAL', 'REFUND_BY_BANK_TRANSFER_EU', 'ONLINE_TRANSFER_CREDIT', 'REVERSAL','CREDIT_ENTRY_DE','DEBT_COLLECTION_DE'), 
    'ONLINE_TRANSFER' => array('ONLINE_TRANSFER', 'REFUND_BY_BANK_TRANSFER_EU', 'ONLINE_TRANSFER_CREDIT', 'REVERSAL','CREDIT_ENTRY_DE','DEBT_COLLECTION_DE'), 
    'PAYPAL' => array('PAYPAL', 'SUBSCRIPTION_STOP', 'SUBSCRIPTION_REACTIVATE', 'PAYPAL_BOOKBACK'),
    'PREPAYMENT' => array('INVOICE_START', 'INVOICE_CREDIT', 'SUBSCRIPTION_STOP', 'SUBSCRIPTION_REACTIVATE', 'REFUND_BY_BANK_TRANSFER_EU'), 
    'CASHPAYMENT' => array('CASHPAYMENT', 'CASHPAYMENT_CREDIT', 'CASHPAYMENT_REFUND'), 
    'INVOICE' => array('INVOICE_START', 'INVOICE_CREDIT', 'SUBSCRIPTION_STOP', 'SUBSCRIPTION_REACTIVATE', 'GUARANTEED_INVOICE', 'REFUND_BY_BANK_TRANSFER_EU', 'GUARANTEED_INVOICE_BOOKBACK','CREDIT_ENTRY_DE','DEBT_COLLECTION_DE'), 
    'EPS' => array('EPS', 'ONLINE_TRANSFER_CREDIT', 'REFUND_BY_BANK_TRANSFER_EU', 'REVERSAL','CREDIT_ENTRY_DE','DEBT_COLLECTION_DE'), 
    'GIROPAY' => array('GIROPAY', 'ONLINE_TRANSFER_CREDIT', 'REFUND_BY_BANK_TRANSFER_EU', 'REVERSAL','CREDIT_ENTRY_DE','DEBT_COLLECTION_DE'), 
    'PRZELEWY24' => array('PRZELEWY24', 'PRZELEWY24_REFUND'));
    
	/**
     * Constructor for initiate the callback process
     *
     * @param aryCaptureParams
     * @param qb
     * @param container
     * @param translator
     * @return null
     */
    public function __construct($aryCaptureParams, $qb, $container, $translator)
    {
        $this->aryCaptureParams = $aryCaptureParams;
        $this->qb = $qb;
        $this->container = $container;
        $this->doctrineHelper = $container->get('oro_entity.doctrine_helper');
        $this->translator = $translator;
        $this->novalnetHelper = new NovalnetHelper();
        $this->novalnetConfig = $this->novalnetHelper->getNovalnetConfig($this->container);
        self::validateCaptureParams($this->aryCaptureParams);
        $this->startProcess();
    }
    
    /**
     * Processes the callback script
     *
     * @param null
     * @return null
     */
    public function startProcess()
    {		
		$nnCaptureParams       = self::getCaptureParams($this->aryCaptureParams);
		$nntransHistory       = self::getOrderReference($nnCaptureParams);
		$currency = isset($this->aryCaptureParams['currency']) ? $this->aryCaptureParams['currency'] : $nntransHistory['currency'];
		$callbacklogParams    = array(
            'callback_tid' => $this->aryCaptureParams['tid'],
            'org_tid' => $nntransHistory['tid'],
            'callback_amount' => $this->aryCaptureParams['amount'],
            'order_no' => $nntransHistory['orderNo'],
            'date' => date('Y-m-d H:i:s')
        );
		if (self::getPaymentTypeLevel() == 'collections_payments') {
			// Credit entry payment and Collections available
			if($nntransHistory['paid_amount'] < $nntransHistory['amount'] && in_array($nnCaptureParams['payment_type'],array('INVOICE_CREDIT','CASHPAYMENT_CREDIT','ONLINE_TRANSFER_CREDIT'))){
				$paidAmount = (empty($nntransHistory['paid_amount']) ? 0 :$nntransHistory['paid_amount'])  + $nnCaptureParams['amount'];				
				$callbackComments = sprintf($this->translator->trans('oro.novalnet_callback.paid.message'), $this->aryCaptureParams['tid_payment'], sprintf('%.2f', $nnCaptureParams['amount'] / 100) . ' ' . $currency, date('d-m-Y'), date('H:i:s'), $this->aryCaptureParams['tid']);
				self::setCallbackComments($nntransHistory['orderNo'], $callbackComments);
				$this->insertCallbackTable($callbacklogParams);
				if ($paidAmount >= $nntransHistory['amount'] && $nnCaptureParams['payment_type'] != 'ONLINE_TRANSFER_CREDIT') {
                    $this->novalnetHelper->setPaymentStatus($this->qb, $this->doctrineHelper, 'full', $nntransHistory['orderNo']);
                }
                self::sendNotifyMail(array(
                    'comments' => $callbackComments,
                    'order_no' => $nntransHistory['orderNo'],
                ));
                self::debugMessage($callbackComments, $nntransHistory['orderNo']);
			 }
			 elseif($nntransHistory['paid_amount'] >= $nntransHistory['amount'] && in_array($this->aryCaptureParams['payment_type'],array('INVOICE_CREDIT','CASHPAYMENT_CREDIT','ONLINE_TRANSFER_CREDIT'))){
				   self::debugMessage('Novalnet callback received. Callback Script executed already. Refer Order :' . $nntransHistory['orderNo'], $nntransHistory['orderNo']);
			 }
			 else {
				 $callbackComments = sprintf($this->translator->trans('oro.novalnet_callback.paid.message'), $this->aryCaptureParams['tid_payment'], sprintf('%.2f', $nnCaptureParams['amount'] / 100) . ' ' . $currency, date('d-m-Y'), date('H:i:s'), $this->aryCaptureParams['tid']);
				 self::setCallbackComments($nntransHistory['orderNo'], $callbackComments);
				 self::sendNotifyMail(array(
                    'comments' => $callbackComments,
                    'order_no' => $nntransHistory['orderNo'],
                ));
				  // Log callback process
				$this->insertCallbackTable($callbacklogParams);				
                self::debugMessage($callbackComments, $nntransHistory['orderNo']);
			 }
			
		}
		 elseif (self::getPaymentTypeLevel() == 'charge_back_payments') {
            //Level 1 payments - Type of Chargebacks
            $chargebackComments   = sprintf($this->translator->trans('oro.novalnet_callback.chargeback.message'), $nnCaptureParams['tid_payment'], sprintf('%.2f', $this->aryCaptureParams['amount'] / 100) . ' ' . $currency, date('d-m-Y H:i:s'), $nnCaptureParams['tid']);
            $bookbackComments   = sprintf($this->translator->trans('oro.novalnet_callback.bookback.message'), $nnCaptureParams['tid_payment'], sprintf('%.2f', $this->aryCaptureParams['amount'] / 100) . ' ' . $currency, date('d-m-Y H:i:s'), $nnCaptureParams['tid']);
            
            $callbackComments = (in_array($nnCaptureParams['payment_type'], array('PAYPAL_BOOKBACK','CREDITCARD_BOOKBACK','PRZELEWY24_REFUND','GUARANTEED_INVOICE_BOOKBACK','GUARANTEED_SEPA_BOOKBACK','CASHPAYMENT_REFUND','REFUND_BY_BANK_TRANSFER_EU'))) ?  $bookbackComments : $chargebackComments;
            
            $this->setCallbackComments($nntransHistory['orderNo'], $callbackComments);
            // Send notification mail to Merchant
            self::sendNotifyMail(array('comments' => $callbackComments,'order_no' => $nntransHistory['orderNo']));
            self::debugMessage($callbackComments, $nnCaptureParams['order_no']);
        }
        elseif (self::getPaymentTypeLevel() == 'available_payments') {
			if ($nnCaptureParams['payment_type'] == 'PAYPAL') {
				if ($nnCaptureParams['tid_status'] == 100 &&  in_array($nntransHistory['gatewayStatus'], array(85, 90))) {
					// Full Payment paid
                    // Update order status due to full payment
					$callbackComments = sprintf($this->translator->trans('oro.novalnet_callback.executed.message'), $nnCaptureParams['tid'], sprintf('%0.2f', $nnCaptureParams['amount'] / 100) . ' ' . $this->aryCaptureParams['currency'], date('d-m-Y'), date('H:i:s'));
					$this->setCallbackComments($nntransHistory['orderNo'], $callbackComments);
					$this->novalnetHelper->setPaymentStatus($this->qb, $this->doctrineHelper, 'full', $nntransHistory['orderNo']);
					$this->insertCallbackTable($callbacklogParams);
					$this->novalnetDbUpdate($nntransHistory['orderNo'], $nnCaptureParams['tid_status']);
					// Send notification mail to Merchant
                    self::sendNotifyMail(array('comments' => $callbackComments,'order_no' => $nntransHistory['orderNo']));
					self::debugMessage($callbackComments, $nntransHistory['orderNo']);
				}
				else {
					self::debugMessage('Novalnet callback received. Order already paid.', $nntransHistory['orderNo']);
				}
			}
			else if ($nnCaptureParams['payment_type'] == 'PRZELEWY24') {
				if ($nnCaptureParams['tid_status'] == '100') {
					if ($nntransHistory['paid_amount'] == 0) {
						// Full Payment paid
                        // Update order status due to full payment
						$callbackComments = sprintf($this->translator->trans('oro.novalnet_callback.executed.message'), $nnCaptureParams['tid'], sprintf('%0.2f', $nnCaptureParams['amount'] / 100) . ' ' . $this->aryCaptureParams['currency'], date('d-m-Y'), date('H:i:s'));					    
					    $status = ($nnCaptureParams['status'] == '100' && $nnCaptureParams['tid_status'] == '86') ? 'pending' : 'full';
					    $this->setCallbackComments($nntransHistory['orderNo'], $callbackComments);
					    $this->novalnetHelper->setPaymentStatus($this->qb, $this->doctrineHelper, $status, $nntransHistory['orderNo']);
					    $this->insertCallbackTable($callbacklogParams);	
					    $this->novalnetDbUpdate($nntransHistory['orderNo'], $nnCaptureParams['tid_status']);
					    // Send notification mail to Merchant
                        self::sendNotifyMail(array('comments' => $callbackComments,'order_no' => $nntransHistory['orderNo']));	
					    self::debugMessage($callbackComments, $nnCaptureParams['order_no']);				
					}
					else {
						self::debugMessage("Novalnet callback received. Order already paid.", $nntransHistory['orderNo']);
					}
				}
				else if($nnCaptureParams['tid_status'] != '86') {
					$message          = (($nnCaptureParams['status_message']) ? $nnCaptureParams['status_message'] : (($nnCaptureParams['status_text']) ? $nnCaptureParams['status_text'] : (($nnCaptureParams['status_desc']) ? $nnCaptureParams['status_desc'] : $this->translator->trans('oro.novalnet_callback.payment_not_success.message'))));
                    $callbackComments = sprintf($this->translator->trans('oro.novalnet_callback.przelewy24_cancel.message'), $message);
                    $this->novalnetHelper->setPaymentStatus($this->qb, $this->doctrineHelper, 'declined', $nntransHistory['orderNo']);
                    $this->setCallbackComments($nntransHistory['orderNo'], $callbackComments);
                    $this->novalnetDbUpdate($nntransHistory['orderNo'], $nnCaptureParams['tid_status']);
                    // Logcallback process
                    $this->insertCallbackTable($callbacklogParams);
                    // Send notification mail to Merchant
                    self::sendNotifyMail(array('comments' => $callbackComments,'order_no' => $nntransHistory['orderNo']));
					self::debugMessage($callbackComments, $nnCaptureParams['order_no']);
				}
			}
			
			else if (in_array($nnCaptureParams['payment_type'], array('INVOICE_START','GUARANTEED_INVOICE','DIRECT_DEBIT_SEPA','GUARANTEED_DIRECT_DEBIT_SEPA', 'CREDITCARD')) && in_array($nntransHistory['gatewayStatus'], array(75,91,99,98)) && in_array($nnCaptureParams['tid_status'], array(91,99,100)) && $nnCaptureParams['status'] == '100') {
				
				$callbackComments = '';
				if( in_array($nnCaptureParams['tid_status'],array(99,91)) && $nntransHistory['gatewayStatus'] == 75){
					$callbackComments = sprintf($this->translator->trans('oro.novalnet_callback.pending_to_onhold.message'), $nnCaptureParams['tid'], date('d-m-Y'), date('H:i:s'));
				}
				else if($nnCaptureParams['tid_status'] == 100 && in_array( $nntransHistory['gatewayStatus'], array(75,91,99,98))){
					$callbackComments = sprintf($this->translator->trans('oro.novalnet_callback.trans_confirm.message'), date('d-m-Y H:i:s'));	
					$status = ($nntransHistory['paymentType'] == 'INVOICE_START') ? 'pending' : 'full';
					$this->novalnetHelper->setPaymentStatus($this->qb, $this->doctrineHelper, $status, $nntransHistory['orderNo']);			
				}
				if(!empty($callbackComments)) {
					if($nntransHistory['gatewayStatus'] == '75' && $nnCaptureParams['payment_type'] == 'GUARANTEED_INVOICE') {
						$nnCaptureParams['amount'] = sprintf('%0.2f', $nnCaptureParams['amount'] / 100);
						$callbackComments .= $this->novalnetHelper->prepareComments($nnCaptureParams, $this->translator);
					}
					$this->setCallbackComments($nntransHistory['orderNo'], $callbackComments);
					$this->novalnetDbUpdate($nntransHistory['orderNo'], $nnCaptureParams['tid_status']);
					// Send notification mail to Merchant
					self::sendNotifyMail(array('comments' => $callbackComments,'order_no' => $nntransHistory['orderNo']));
					self::debugMessage($callbackComments, $nntransHistory['orderNo']);
				}
				else {
					self::debugMessage('Novalnet callback received. Payment type ( ' . $nnCaptureParams['payment_type'] . ' ) is
                    not applicable for this process!', $nntransHistory['orderNo']);
				}
					
			}
			else {
                self::debugMessage('Novalnet callback received. Payment type ( ' . $nnCaptureParams['payment_type'] . ' ) is
                    not applicable for this process!', $nntransHistory['orderNo']);
            }	
		}
	}
	
    
    /**
     * Validate the required params to process callback
     *
     * @param array $request
     * @return null
     */
    public function validateCaptureParams($request)
    {
        // Validate Authenticated IP
        $realHostIp = gethostbyname('pay-nn.de');
        if (empty($realHostIp)) {
            self::debugMessage('Novalnet HOST IP missing');
        }
        $callerIp = $this->novalnetHelper->getIp();
        if ($callerIp != $realHostIp && !$this->novalnetConfig['callback_testmode']) {
            self::debugMessage('Unauthorised access from the IP [' . $callerIp . ']');
        }
        if (!array_filter($request)) {
            self::debugMessage('Novalnet callback received. No params passed over!');
        }
        $hParamsRequired = array('vendor_id','tid','payment_type','status','tid_status');
        
        if (in_array($request['payment_type'], array_merge($this->aryChargebacks, $this->aryCollection))) {
			array_push($hParamsRequired, 'tid_payment');
        }
        $error = '';
        foreach ($hParamsRequired as $v) {
			if (!isset($request[$v]) || ($request[$v] == '')) {
                    $error .= 'Novalnet callback received. Required param (' . $v . ') missing! <br>';                    
            } elseif (in_array($v, array('tid','signup_tid','tid_payment')) && !preg_match('/^[0-9]{17}$/', $request[$v])) {
                    $error .= 'Novalnet callback received. TID [' . $request[$v] . '] is not valid.';
            }
        }
        if (!empty($error)) {
			self::debugMessage($error, '');
        }
        
    }
    /**
     * Get order reference from the novalnet_transaction_detail table on shop database
     *
     * @param array $nnCaptureParams
     * @return array
     */
    public function getOrderReference($nnCaptureParams)
    {
		$q = $this->qb->createQueryBuilder();
		$q->select('nn')
          ->from('OroNovalnetPaymentBundle:NovalnetTransactionDetails', 'nn')
          ->where('nn.tid = :tid')
          ->setParameter('tid', $nnCaptureParams['shop_tid']);
        $result = $q->getQuery()->getArrayResult();
        $nntransHistory = !empty($result) ? $result[0] : $result;

		
		$orderNo = (isset($nntransHistory['orderNo']) ? $nntransHistory['orderNo'] : (isset($nnCaptureParams['order_no']) ? $nnCaptureParams['order_no'] : '' ));
		
		$queryBuilder = $this->qb->createQueryBuilder();
		$orderDetailsQuery = $queryBuilder->select('orders')
		                  ->from('OroOrderBundle:Order', 'orders')
					      ->where('orders.id = :orderId')
					      ->setParameter('orderId', $orderNo);
		$orderDetails = $orderDetailsQuery->getQuery()->getOneOrNullResult();	

	
		if (empty($orderDetails)) {
            if (in_array($nnCaptureParams['status'], array(100, 90))) {
                self::criticalMailComments($nnCaptureParams);
            }
        }
        if(empty($nntransHistory) && !empty($orderDetails->getId())) {
			$this->handleCommunicationFailure($nnCaptureParams);
		}			      
		
		if ($nnCaptureParams['payment_type'] == 'TRANSACTION_CANCELLATION') { // transaction cancelled for invoice and sepa payments
            $callbackComments = sprintf($this->translator->trans('oro.novalnet_callback.trans_cancelled.message'), date('d-m-Y H:i:s'));
            $this->novalnetDbUpdate($nntransHistory['orderNo'], $nnCaptureParams['tid_status']);
            $this->novalnetHelper->setPaymentStatus($this->qb, $this->doctrineHelper, 'declined', $orderDetails->getId());
            self::setCallbackComments($orderDetails->getId(), $callbackComments);
            self::debugMessage($callbackComments);
        }
        
		$paymentMethod = (in_array($nntransHistory['paymentType'], array('GUARANTEED_INVOICE','GUARANTEED_DIRECT_DEBIT_SEPA')) ? str_replace('GUARANTEED_', '', $nntransHistory['paymentType']) : $nntransHistory['paymentType']);
		
		
		
		if (!empty($nnCaptureParams['order_no']) && $nntransHistory['orderNo'] != $nnCaptureParams['order_no']) {
            self::debugMessage('Novalnet callback received. Order no is not valid', $nnCaptureParams['order_no']);
        } elseif ((!array_key_exists($paymentMethod, $this->aPaymentTypes)) || !in_array($nnCaptureParams['payment_type'], $this->aPaymentTypes[$paymentMethod])) {
            self::debugMessage('Novalnet callback received. Payment type [' . $nnCaptureParams['payment_type'] . '] is mismatched!', $nnCaptureParams['order_no']);
        }

       $nntransHistory['paid_amount'] = $this->getOrderPaidAmount($nnCaptureParams['shop_tid']); 
       $nntransHistory['customercomment']    = $orderDetails->getCustomerNotes();
       $nntransHistory['tid']                = $nnCaptureParams['shop_tid'];
       return $nntransHistory;
	}
    
    /**
     * Get given payment_type level for process
     *
     * @param null
     * @return string
     */
    public function getPaymentTypeLevel()
    {
        if (in_array($this->aryCaptureParams['payment_type'], $this->aryPayments)) {
            return 'available_payments';
        } elseif (in_array($this->aryCaptureParams['payment_type'], $this->aryChargebacks)) {
            return 'charge_back_payments';
        } elseif (in_array($this->aryCaptureParams['payment_type'], $this->aryCollection)) {
            return 'collections_payments';
        }
    }
    
    /**
     * Perform parameter validation process
     * Set empty value if not exist in aryCapture
     *
     * @param $aryCapture
     * @return array
     */
    public function getCaptureParams($aryCapture = array())
    {
        $aryCapture['shop_tid'] = $aryCapture['tid'];
        if (in_array($aryCapture['payment_type'], array_merge($this->aryChargebacks, $this->aryCollection))) { // Collection Payments or Chargeback Payments
            $aryCapture['shop_tid'] = $aryCapture['tid_payment'];
        }
        return $aryCapture;
    }
    
    
    /**
     * Display the error message
     *
     * @param string $errorMsg
     * @param string $orderNo
     * @return null
     */
    public function debugMessage($errorMsg, $orderNo = null)
    {
        if ($orderNo) {
            echo 'message=' . $errorMsg . 'ordernumber=' . $orderNo;
        } else {
            echo 'message=' . $errorMsg;
        }

        exit;
    }
    
    /**
     * Get the order paid amount from database
     *
     * @param integer $tid
     * @return integer|null
     */
    public function getOrderPaidAmount($tid)
    {
        if (empty($tid)) {
            return null;
        }
        
        $q = $this->qb->createQueryBuilder();
		$q->select('SUM(n.callbackAmount) AS amount')
          ->from('OroNovalnetPaymentBundle:NovalnetCallbackHistory', 'n')
          ->where('n.orgTid = :id')
          ->setParameter('id', $tid);
        $result = $q->getQuery()->getArrayResult();
        return !empty($result) ? $result[0]['amount'] : '0';
    }
	
	/**
     * Set payment status
     *
     * @param orderNo
     * @param comments
     */
	public function setCallbackComments($orderNo, $comments)
	{		
		$q = $this->qb->createQueryBuilder();
		$q->select('nn')
          ->from('OroOrderBundle:Order', 'nn')
          ->where('nn.id = :id')
          ->setParameter('id', $orderNo);
        $orderDetailsEntity = $q->getQuery()->getOneOrNullResult();
        $customerNotes = $orderDetailsEntity->getCustomerNotes().' | '.$comments;
        
        $orderDetailsEntity->setCustomerNotes($customerNotes);
		$em = $this->doctrineHelper->getEntityManager('OroOrderBundle:Order');
        $em->persist($orderDetailsEntity);
        $em->flush($orderDetailsEntity);	
	}
	
	/**
     * Save Callback details in callback history table
     *
     * @param data
     */
	public function insertCallbackTable($data)
	{
		$connection = $this->doctrineHelper->getEntityManager('OroNovalnetPaymentBundle:NovalnetCallbackHistory')->getConnection();
		$connection->insert(
        'oro_novalnet_payment_callback_history',
        $data
        );
	}
	
	/**
     * Update Gatewaystatus in novalnet transaction table
     *
     * @param orderNo
     * @param gatewayStatus
     */
	public function novalnetDbUpdate($orderNo, $gatewayStatus)
	{
		$queryBuilder = $this->qb->createQueryBuilder();
		$queryBuilder->update('OroNovalnetPaymentBundle:NovalnetTransactionDetails', 'nn');
		$queryBuilder->set('nn.gatewayStatus', ':gatewayStatus')
		             ->where('nn.orderNo = :orderNo')
		             ->setParameter('orderNo', $orderNo)
		             ->setParameter('gatewayStatus', $gatewayStatus);
		$queryBuilder->getQuery()->execute();
		
	}
	
	/**
     * Handle communication failure
     *
     * @param nnCaptureParams
     */
	public function handleCommunicationFailure($nnCaptureParams)
	{
		$paymentTypeVal = $nnCaptureParams['payment_type'] == 'INVOICE_START' ? strtolower($nnCaptureParams['invoice_type']) : strtolower($nnCaptureParams['payment_type']);
		$paymentType = $this->translator->trans('oro.novalnet_payment.payment_name_'.$paymentTypeVal);
		
		$newLine = ' | ';
		$callbackComments  = $this->translator->trans('oro.novalnet_callback.communication_failure.message') . $newLine;
        $callbackComments .= $this->translator->trans('oro.novalnet_payment.payment_comment')  . $newLine;
        $callbackComments .= $paymentType . $newLine;
        $callbackComments .= sprintf($this->translator->trans('oro.novalnet_payment.transaction_id'), $nnCaptureParams['tid']). $newLine;
        
        if ($nnCaptureParams['test_mode'] == 1) { // If test transaction
			$callbackComments .= $this->translator->trans('oro.novalnet_payment.test_order') . $newLine;
        }
		if ((in_array($nnCaptureParams['status'],array('100','90'))) && in_array($nnCaptureParams['tid_status'], array(100,90,85,86,91,98,99,75))) {			

            if($nnCaptureParams['tid_status'] != 100 || in_array($nnCaptureParams['payment_type'], array('INVOICE_START', 'CASHPAYMENT'))) {
				$status = 'pending';
		    }
		    else {
				$status = 'full';
		    }	
		    	    
		    $callbackComments .= $this->novalnetHelper->prepareComments($nnCaptureParams, $this->translator);
		    
            $this->novalnetHelper->setPaymentStatus($this->qb, $this->doctrineHelper, $status, $nnCaptureParams['order_no']);
			$this->novalnetHelper->insertNovalnetTransactionTable($this->container, $nnCaptureParams);
			self::setCallbackComments($nnCaptureParams['order_no'], $callbackComments);
			self::debugMessage($newLine . $callbackComments, $nnCaptureParams['order_no']);
		} else { // Handle failure transaction
			$callbackComments .= (($nnCaptureParams['status_message']) ? $nnCaptureParams['status_message'] : (($nnCaptureParams['status_text']) ? $nnCaptureParams['status_text'] : (($nnCaptureParams['status_desc']) ? $nnCaptureParams['status_desc'] : $this->translator->trans('oro.novalnet_callback.payment_not_success.message')))) . $newLine;
			$this->novalnetHelper->insertNovalnetTransactionTable($this->container, $nnCaptureParams);
			$this->novalnetHelper->setPaymentStatus($this->qb, $this->doctrineHelper, 'declined', $nnCaptureParams['order_no']);
			self::setCallbackComments($nnCaptureParams['order_no'], $callbackComments);
			self::debugMessage($callbackComments, $nnCaptureParams['order_no']);
		}
	}
	
	/**
     * Get mail values to send a comments
     *
     * @param array $nnCaptureParams
     * @return array
     */
	public function criticalMailComments($nnCaptureParams)
    {
        $newLine  = PHP_EOL;
        $orderNo = (isset($nnCaptureParams['order_no']) ? $nnCaptureParams['order_no'] : '');
        $comments = $newLine . 'Dear Technic team,' . $newLine . $newLine;
        $comments .= 'Please evaluate this transaction and contact our payment module team at Novalnet.' . $newLine . $newLine;
        $comments .= 'Merchant ID: ' . $nnCaptureParams['vendor_id'] . $newLine;
        $comments .= 'Project ID: ' . (isset($nnCaptureParams['product_id']) ? $nnCaptureParams['product_id'] : '')  . $newLine;
        $comments .= 'TID: ' . $nnCaptureParams['shop_tid'] . $newLine;
        $comments .= 'TID status: ' . $nnCaptureParams['tid_status'] . $newLine;
        $comments .= 'Order no: ' . $orderNo. $newLine;
        $comments .= 'Payment type: ' . $nnCaptureParams['payment_type'] . $newLine;
        $comments .= 'E-mail: ' . (isset($nnCaptureParams['email']) ? $nnCaptureParams['email'] : ''). $newLine;
        self::sendNotifyMail(array(
            'comments' => $comments,
            'tid' => $nnCaptureParams['shop_tid'],
            'order_no' => $orderNo
        ), true);
    }
	
	/**
     * Send notify email after callback process
     *
     * @param array $datas
     * @param boolean $missingTransactionNotify
     * @return null
     */
    public function sendNotifyMail($datas, $missingTransactionNotify = false)
    {
		$email = new Email();
		$config = $this->container->get('oro_config.global');
		$processor = $this->container->get('oro_email.mailer.processor');
        $sender = $config->get('oro_notification.email_notification_sender_email');
        $comments = '';
        $email->setFrom($sender);
		if ($missingTransactionNotify) { //This is only for missing transaction notification
            $mailSubject = 'Critical error on shop system order not found for TID: ' . $datas['tid'];
            $email->setTo(array('technic@novalnet.de'));
			$email->setSubject($mailSubject);
			$email->setBody($datas['comments']);
		    try {         
			  $processor->process($email);
              $comments = 'Mail Sent Successfully';
		   }
		   catch (\Swift_SwiftException $exception) {
			 $comments = 'unable to send email';
		   }
        } else if ($this->novalnetConfig['email_notification'] && !empty($this->novalnetConfig['email_to'])) {
			
			$email->setTo(explode(',', $this->novalnetConfig['email_to']));
			if(!empty($this->novalnetConfig['email_bcc'])) {				
				$email->setBcc(explode(',',$this->novalnetConfig['email_bcc']));
			}
			$mailSubject = 'Novalnet Callback script notification - Order No : ' . $datas['order_no'];
			
			$email->setSubject($mailSubject);
			$email->setBody($datas['comments']);
			$processor = $this->container->get('oro_email.mailer.processor');
		    try {         
			  $processor->process($email);
              $comments = 'Mail Sent Successfully';
		   }
		   catch (\Swift_SwiftException $exception) {
			 $comments = 'unable to send email';
		   }
		}
		
             echo $comments;        
	}
    
}
