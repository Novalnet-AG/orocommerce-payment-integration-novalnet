<?php

namespace Oro\Bundle\NovalnetPaymentBundle\Controller\Frontend;

use Oro\Bundle\PaymentBundle\Entity\PaymentTransaction;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Oro\Bundle\NovalnetPaymentBundle\PaymentMethod\NovalnetHelper;
use Oro\Bundle\EntityBundle\ORM\DoctrineHelper as DoctrineHelper;
use Oro\Bundle\NovalnetPaymentBundle\PaymentMethod\NovalnetCallback;

/**
 * Novalnet payment method redirect Controller
 */
class NovalnetRedirectController extends Controller
{	
	/** @var array */
	private $nnRedirectPayments = array('ONLINE_TRANSFER', 'IDEAL', 'GIROPAY', 'PAYPAL', 'PRZELEWY24', 'EPS');
    
     /**
     * @Route(
     *     "/return/{accessIdentifier}",
     *     name="oro_novalnet_payment_frontend_novalnet_redirect_return",
     * 	   requirements={"accessIdentifier"="[a-zA-Z0-9\-]+"}
     * )
     * @ParamConverter("paymentTransaction", options={"accessIdentifier" = "accessIdentifier"})
     * @Method({"GET", "POST"})
     * @param PaymentTransaction $paymentTransaction
     * @param Request $request
     * @return array
     */
    public function returnAction(PaymentTransaction $paymentTransaction, Request $request)
    {		
		$data = $request->request->all();
	    $qb = $this->getDoctrine()->getManager();
		$doctrineHelper = $this->container->get('oro_entity.doctrine_helper');
        $novalnetHelper = new NovalnetHelper();
        $transactionOptions = $paymentTransaction->getTransactionOptions();
        $novalnetConfig = $novalnetHelper->getNovalnetConfig($this->container);
        //Validate the hash value from the Novalnet server for redirection payments
        if(isset($data['hash2'])) {
			$currentHash = $novalnetHelper->generateHash($data, $novalnetConfig['payment_access_key']);
			if (($data['hash2'] != $currentHash)) {
				$errorMsg = $this->get('translator')->trans('oro.novalnet_payment.hash_check_failed');      
				$this->addFlash('error', $errorMsg);
				$urlParams = ['id' => $transactionOptions['checkoutId'], 'transition' => 'payment_error' ];
				return $this->redirectToRoute('oro_checkout_frontend_checkout', $urlParams);						
			}
		}
 
        // set payment status 
        $pendingPayment = array(91,85,99,86,98,90,75);
        if((in_array($data['tid_status'], $pendingPayment)) || (in_array($data['payment_type'], array('INVOICE_START', 'CASHPAYMENT')))) {
			$status = 'pending';
		}
		else {
			$status = 'full';
		}
		              
        $novalnetHelper->setPaymentStatus($qb, $doctrineHelper, $status, $data['order_no']);
        // saves transaction details
        $novalnetHelper->insertNovalnetTransactionTable($this->container, $data);     
        $novalnetHelper->setPaymentComments($qb, $doctrineHelper, $this->get('translator'), $data);   
         
        // redirect to success page
		$urlParams = ['id' => $transactionOptions['checkoutId'], 'transition' => 'finish_checkout' ];
		return $this->redirectToRoute('oro_checkout_frontend_checkout', $urlParams);
	}
	
     /**
     * @Route(
     *     "/error-return/{accessIdentifier}",
     *     name="oro_novalnet_payment_frontend_novalnet_redirect_error",
     * 	   requirements={"accessIdentifier"="[a-zA-Z0-9\-]+"}
     * )
     * @ParamConverter("paymentTransaction", options={"accessIdentifier" = "accessIdentifier"})
     * @Method({"GET", "POST"})
     * @param PaymentTransaction $paymentTransaction
     * @param Request $request
     * @return array
     */
    public function errorReturnAction(PaymentTransaction $paymentTransaction, Request $request)
    {
		 $data = $request->request->all();
		 $qb = $this->getDoctrine()->getManager();
		 $doctrineHelper = $this->container->get('oro_entity.doctrine_helper');
		 $novalnetHelper = new NovalnetHelper();
		 $novalnetHelper->setPaymentStatus($qb, $doctrineHelper, 'declined', $data['order_no']); 
		 
		 // saves transaction details
         if(isset($data['tid'])) {
			 $novalnetHelper->insertNovalnetTransactionTable($this->container, $data);     
             $novalnetHelper->setPaymentComments($qb, $doctrineHelper, $this->get('translator'), $data, true);
		 }
		 
		 // redirect to checkout page                  
         $transactionOptions = $paymentTransaction->getTransactionOptions(); 
         $errorMsg = !empty($data['status_desc']) ? $data['status_desc'] : $data['status_text'];      
         $this->addFlash('error', $errorMsg);
		 $urlParams = ['id' => $transactionOptions['checkoutId'], 'transition' => 'payment_error' ];
		 return $this->redirectToRoute('oro_checkout_frontend_checkout', $urlParams);
           
	}
	
	/**
     * @Route(
     *     "/callback",
     *     name="oro_novalnet_payment_frontend_novalnet_callback"
     * )
     * @Method({"GET", "POST"})
     * @param Request $request
     * @return array
     */
    public function callbackAction(Request $request)
    {		
		new NovalnetCallback($request->request->all() + $request->query->all(), $this->getDoctrine()->getManager(), $this->container, $this->get('translator'));      
	}
	

}
