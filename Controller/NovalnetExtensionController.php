<?php

namespace Novalnet\Bundle\NovalnetBundle\Controller;

use Oro\Bundle\PaymentBundle\Entity\PaymentTransaction;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Oro\Bundle\SecurityBundle\Attribute\CsrfProtection;
use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetTransactionDetails;
use Oro\Bundle\OrderBundle\Entity\Order;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Novalnet\Bundle\NovalnetBundle\Client\Gateway;
use Oro\Bundle\EntityBundle\ORM\DoctrineHelper;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetHelper;
use Symfony\Contracts\Translation\TranslatorInterface;
use Oro\Bundle\PaymentBundle\Provider\PaymentTransactionProvider;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider\NovalnetBancontactMethodProvider;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider\NovalnetCreditCardMethodProvider;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider\NovalnetEpsMethodProvider;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider\NovalnetGuaranteedInvoiceMethodProvider;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider\NovalnetGuaranteedSepaMethodProvider;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider\NovalnetIdealMethodProvider;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider\NovalnetAchMethodProvider;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider\NovalnetInstalmentInvoiceMethodProvider;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider\NovalnetInstalmentSepaMethodProvider;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider\NovalnetInvoiceMethodProvider;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider\NovalnetMultibancoMethodProvider;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider\NovalnetPaypalMethodProvider;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider\NovalnetPostfinanceCardMethodProvider;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider\NovalnetPostfinanceMethodProvider;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider\NovalnetPrepaymentMethodProvider;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider\NovalnetPrzelewyMethodProvider;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider\NovalnetSepaMethodProvider;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider\NovalnetAlipayMethodProvider;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider\NovalnetWechatpayMethodProvider;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider\NovalnetOnlinebanktransferMethodProvider;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider\NovalnetTrustlyMethodProvider;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider\NovalnetKakaopayMethodProvider;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider\NovalnetTwintMethodProvider;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider\NovalnetMbwayMethodProvider;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider\NovalnetPayconiqMethodProvider;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider\NovalnetBlikMethodProvider;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider\NovalnetNaverpayMethodProvider;
use Symfony\Component\Routing\Annotation\Route;
use Oro\Bundle\PaymentBundle\Method\Provider\PaymentMethodProviderInterface;

/**
 * Novalnet Extension Controller
 */
class NovalnetExtensionController extends AbstractController
{
	private DoctrineHelper $doctrineHelper;
	
	private Gateway $gateway;
	
	public function __construct(DoctrineHelper $doctrineHelper, Gateway $gateway)
    {
        $this->doctrineHelper = $doctrineHelper;
        $this->gateway = $gateway;
    }


	/**
     * @param PaymentTransaction $paymentTransaction
     * @return array
     */
	#[Route(
        path: '/show-manage-transaction/{paymentTransactionId}/',
        name: 'novalnet_transaction_show_manage_transaction',
        requirements: ['paymentTransactionId' => '[a-zA-Z0-9\-]+'],
        methods: ['GET']
    )]
    #[Template]
    #[ParamConverter('paymentTransaction', class: PaymentTransaction::class, options: ['id' => 'paymentTransactionId'])]
    public function showManageTransactionAction(PaymentTransaction $paymentTransaction)
    {
        $transactionDetails = $this->getNovalnetTransactionDetails($paymentTransaction);

        return ['transactionDetails' => $transactionDetails];
    }


	/**
     * @param PaymentTransaction $paymentTransaction
     * @return array
     */
	#[Route(
        path: '/show-refund/{paymentTransactionId}/',
        name: 'novalnet_transaction_show_refund',
        requirements: ['paymentTransactionId' => '[a-zA-Z0-9\-]+'],
        methods: ['GET']
    )]
    #[Template]
    #[ParamConverter('paymentTransaction', class: PaymentTransaction::class, options: ['id' => 'paymentTransactionId'])]
    public function showRefundAction(PaymentTransaction $paymentTransaction)
    {
        $transactionDetails = $this->getNovalnetTransactionDetails($paymentTransaction);
        
        $transactionDetails['amountToRefund'] = $transactionDetails['amount'];
        if(isset($transactionDetails['refundedAmount']) && $transactionDetails['refundedAmount'] > 0) {
			$transactionDetails['amountToRefund'] -= $transactionDetails['refundedAmount'];
		}
		
        return ['transactionDetails' => $transactionDetails];
    }
    
	/**
     * @param Request $request
     * @return JsonResponse
     */
	#[Route(
        path: '/execute-refund/',
        name: 'novalnet_transaction_execute_refund',
        methods: ['POST']
    )]
    #[Template]
    #[CsrfProtection()]
    public function executeRefundAction(Request $request)
    {
        $tid = $request->get('tid');
        $amount = $request->get('amount');
        $reason = $request->get('reason');
        $paymentAccessKey = $request->get('paymentAccessKey');
        $paymentTransactionID = $request->get('paymentTransactionID');

        $data = [
			'transaction' => [
				'tid'    => $tid,
				'amount' => $amount,
			],
			'custom' => [
				'shop_invoked' => 1
			]
	    ];
        
        if(!empty($reason))
        {
            $data['transaction']['reason'] = $reason;
        }
        
        $response = $this->gateway->send($paymentAccessKey, $data, 'https://payport.novalnet.de/v2/transaction/refund');

        if ($response['result']['status_code'] == 100) {
            $repository = $this->doctrineHelper->getEntityRepository(NovalnetTransactionDetails::class);
            $nnTransactionDetail = $repository->findOneBy(['tid' => $tid]);

			$orderRepository = $this->doctrineHelper->getEntityRepository(Order::class);
            $orderDetails = $orderRepository->findOneBy(['id' => $nnTransactionDetail->getOrderNo()]);

			$novalnetHelper = $this->container->get(NovalnetHelper::class);
            $translator = $this->container->get(TranslatorInterface::class);
            
            $paymentTransaction = $this->doctrineHelper->getEntityRepository(PaymentTransaction::class)->findOneBy([
				'id' =>  $paymentTransactionID
            ]);

            $comments = sprintf(
                $translator->trans('novalnet.refund_with_parent_tid'),
                $response['transaction']['tid'],
                $novalnetHelper->amountFormat($response['transaction']['refund']['amount']),
                $response['transaction']['refund']['currency']
            );

            if ($response['transaction']['refund']['tid']) {
                $comments = sprintf(
                    $translator->trans('novalnet.refund_with_child_tid'),
                    $response['transaction']['tid'],
                    $novalnetHelper->amountFormat($response['transaction']['refund']['amount']),
                    $response['transaction']['refund']['currency'],
                    $response['transaction']['refund']['tid']
                );
            }

            $novalnetHelper->updateOrderComments($orderDetails, $this->doctrineHelper, $comments);
            $novalnetHelper->setOrderStatus($response['transaction']['status'], $paymentTransaction);

            $paymentTransactionProvider = $this->container->get(PaymentTransactionProvider::class);
            $paymentTransactionProvider->savePaymentTransaction($paymentTransaction);
            
            if(in_array($nnTransactionDetail->getPaymentType(), ['INSTALMENT_INVOICE', 'INSTALMENT_DIRECT_DEBIT_SEPA'])) {
				$additionalInfo = (array) json_decode($nnTransactionDetail->getAdditionalInfo(), true);
				$instalmentDetails = $additionalInfo['instalmentDetails'] ?? $additionalInfo;
				
				$cycle = $request->get('instalmentCycle');
                    
				$instalmentRefundedAmount = $instalmentDetails[$cycle]['refunded_amount'] ? $instalmentDetails[$cycle]['refunded_amount'] + $response['transaction']['refund']['amount'] : $response['transaction']['refund']['amount'];
				$instalmentDetails[$cycle]['refunded_amount'] = $instalmentRefundedAmount;
				
				if(isset($additionalInfo['instalmentDetails'])) {
					$additionalInfo['instalmentDetails'] = $instalmentDetails;
				}
				else {
					$additionalInfo = $instalmentDetails;
				}
				
				$nnTransactionDetail->setAdditionalInfo(json_encode($additionalInfo));
			}
            
            $refundedAmount = $nnTransactionDetail->getRefundedAmount() + $response['transaction']['refund']['amount'];

            $nnTransactionDetail->setRefundedAmount($refundedAmount);
            $nnTransactionDetail->setStatus($response['transaction']['status']);

            $entityManager = $this->doctrineHelper->getEntityManager(NovalnetTransactionDetails::class);

            $entityManager->persist($nnTransactionDetail);
            $entityManager->flush();
        }


        return new JsonResponse($response);
    }

	/**
     * @param Request $request
     * @return JsonResponse
     */
	#[Route(
        path: '/execute-manage-transaction',
        name: 'novalnet_transaction_execute_manage_transaction',
        methods: ['POST']
    )]
    #[Template]
    #[CsrfProtection()]
    public function executeManageTransactionAction(Request $request)
    {
        $tid = $request->get('tid');
        $action = $request->get('transactionAction');
        $paymentAccessKey = $request->get('paymentAccessKey');
        $paymentTransactionID = $request->get('paymentTransactionID');

        $data = [];

        $data['transaction'] = [
            'tid' => $tid,
        ];
        $data['custom'] = [
            'shop_invoked' => 1
        ];
        
        $url = 'https://payport.novalnet.de/v2/transaction/' . $action;
        
        if($action == 'instalment_cancel') {
			$data['instalment']['tid'] = $tid;
			unset($data['transaction']);
            $url = 'https://payport.novalnet.de/v2/instalment/cancel';
            
            $cancelType = str_replace('nn_', '', $request->get('cancelType'));
			$data['instalment']['cancel_type'] = strtoupper($cancelType);
        }

        $response = $this->gateway->send($paymentAccessKey, $data, $url);
        
        if ($response['result']['status_code'] == 100) {
            $repository = $this->doctrineHelper->getEntityRepository(NovalnetTransactionDetails::class);
            $nnTransactionDetail = $repository->findOneBy(['tid' => $tid]);

            $novalnetHelper = $this->container->get(NovalnetHelper::class);
            $translator = $this->container->get(TranslatorInterface::class);
            
            $orderRepository = $this->doctrineHelper->getEntityRepository(Order::class);
            $orderDetails = $orderRepository->findOneBy(['id' => $nnTransactionDetail->getOrderNo()]);

            $paymentTransaction = $this->doctrineHelper->getEntityRepository(PaymentTransaction::class)->findOneBy([
				'id' =>  $paymentTransactionID
            ]);
       
            $comments = sprintf(
                $translator->trans('novalnet.transaction_confirmed'),
                date('d-m-Y'),
                date('H:i:s')
            );

            if (in_array($response['transaction']['status'], ['DEACTIVATED', 'FAILURE'])) {
                $comments =  sprintf(
                    $translator->trans('novalnet.transaction_cancelled'),
                    date('d-m-Y'),
                    date('H:i:s')
                );
            }
            
            $additionalInfo = (array) json_decode($nnTransactionDetail->getAdditionalInfo(), true);
            
            if(in_array($response['transaction']['status'], ['CONFIRMED', 'PENDING']) && $action == 'capture') {
				if(!empty($response['transaction']['bank_details']) || !empty($additionalInfo['bank_details'])) {
					if(!$response['transaction']['bank_details']) {
						$response['transaction']['bank_details'] = $additionalInfo['bank_details'];
					}
					
					$comments .= PHP_EOL . ' ';
					$novalnetHelper->prepareInvoiceComments($translator, $comments, $response);
				}
				
				if(isset($response['instalment'])) {
					$response['instalment'][$response['instalment']['cycles_executed']] = ['tid' => $response['transaction']['tid']];
					$response['instalment']['formatted_cycle_amount'] = sprintf('%0.2f', $response['instalment']['cycle_amount']/100);
					
                    $additionalInfo['instalmentDetails'] = $response['instalment'];
                    $nnTransactionDetail->setAdditionalInfo(json_encode($additionalInfo));
				}
            }
            
            if($action == 'instalment_cancel') {
				$cancelType = str_replace('nn_', '', $request->get('cancelType'));
				$formattedAmount = $novalnetHelper->amountFormat($response['transaction']['refund']['amount']);
				                    
				if ($cancelType == 'cancel_all_cycles') {
					$comments = sprintf($translator->trans('novalnet.cancel_all_cycles_message'), $tid, date('d-m-Y'));
					$novalnetHelper->setOrderStatus('DEACTIVATED', $paymentTransaction);
				}
				else {
					$comments = sprintf($translator->trans('novalnet.cancel_remaining_cycles_message'), $tid, date('d-m-Y'));
				}
				
				if(isset($additionalInfo['instalmentDetails'])) {
					$additionalInfo['instalmentDetails']['cancel_type'] = $cancelType;
				}
				else {
					$additionalInfo['cancel_type'] = $cancelType;
				}
				$nnTransactionDetail->setAdditionalInfo(json_encode($additionalInfo));
			}
			else {
				$novalnetHelper->setOrderStatus($response['transaction']['status'], $paymentTransaction);
			}
                
            $nnTransactionDetail->setStatus($response['transaction']['status']);
            $entityManager = $this->doctrineHelper->getEntityManager(NovalnetTransactionDetails::class);
            $entityManager->persist($nnTransactionDetail);
            $entityManager->flush();

            $paymentTransactionProvider = $this->container->get(PaymentTransactionProvider::class);
            $paymentTransactionProvider->savePaymentTransaction($paymentTransaction);

            $novalnetHelper->updateOrderComments($orderDetails, $this->doctrineHelper, $comments);
        }
        return new JsonResponse($response);
    }


    /**
     * Get Novalnet Transaction Details
     * @param $paymentTransaction
     * @return array
     */
    public function getNovalnetTransactionDetails($paymentTransaction)
    {
        $order = $this->doctrineHelper->getEntity(
            $paymentTransaction->getEntityClass(),
            $paymentTransaction->getEntityIdentifier()
        );

        $paymentCode = preg_replace('/_[0-9]{1,}$/', '', $paymentTransaction->getPaymentMethod());
        
        $paymentProviderNamespace = 'Novalnet\/Bundle\/NovalnetBundle\/PaymentMethod\/Provider\/';
        $paymentProviderNamespace = str_replace('/', '', $paymentProviderNamespace);
        $paymentProviderClass = str_replace(' ', '', ucwords(str_replace('_', ' ', $paymentCode)));
        
        $paymentProvider = $this->container->get(trim($paymentProviderNamespace.$paymentProviderClass.'MethodProvider'::class));
        $paymentMethod = $paymentProvider->getPaymentMethod($paymentTransaction->getPaymentMethod());
		
        $paymentAccessKey = $paymentMethod->config->getPaymentAccessKey();

        $repository = $this->doctrineHelper->getEntityRepository(NovalnetTransactionDetails::class);

        $qryBuilder = $repository->createQueryBuilder('nn')
            ->select('nn.tid, nn.amount, nn.paymentType, nn.additionalInfo, nn.status, nn.refundedAmount')
            ->where('nn.orderNo = :orderNo')
            ->setParameter('orderNo', (string) $order->getId());

        $transactionDetails = $qryBuilder->getQuery()->getArrayResult();
        $transactionDetails[0]['instalmentDetails'] = [];

        if($transactionDetails[0]['additionalInfo']) {
            $additionalInfo = (array) json_decode($transactionDetails[0]['additionalInfo'], true);
            
            if(isset($additionalInfo['cycle_dates']) || isset($additionalInfo['instalmentDetails'])) {
				if($additionalInfo['cycle_dates']) {
					$transactionDetails[0]['instalmentDetails'] = $additionalInfo;
				}
				else {
					$transactionDetails[0]['instalmentDetails'] = $additionalInfo['instalmentDetails'];
				}
				
				$cycleDates = $transactionDetails[0]['instalmentDetails']['cycle_dates'];
				ksort($cycleDates, SORT_NUMERIC);
				$transactionDetails[0]['instalmentDetails']['cycle_dates'] = $cycleDates;
								
				$totalCycles = count($transactionDetails[0]['instalmentDetails']['cycle_dates']);
				$lastCycleAmount = sprintf('%.2f', ($transactionDetails[0]['instalmentDetails']['total_amount']/100)) - ($transactionDetails[0]['instalmentDetails']['formatted_cycle_amount'] * ($totalCycles - 1));
			
				$transactionDetails[0]['instalmentDetails']['last_cycle_amount'] = $lastCycleAmount;
				$transactionDetails[0]['instalmentDetails']['total_cycles'] = $totalCycles;
			}
        }
        
        $transactionDetails[0]['paymentAccessKey'] = $paymentAccessKey;
        $transactionDetails[0]['paymentTransactionID'] = $paymentTransaction->getId();
        
        return $transactionDetails[0];
    }
    
    #[\Override]
    public static function getSubscribedServices(): array
    {
		
        return array_merge(parent::getSubscribedServices(), [
            DoctrineHelper::class,
            Gateway::class,
            NovalnetHelper::class,
            TranslatorInterface::class,
            PaymentTransactionProvider::class,
            NovalnetCreditCardMethodProvider::class,
            NovalnetBancontactMethodProvider::class,
            NovalnetEpsMethodProvider::class,
            NovalnetGuaranteedInvoiceMethodProvider::class,
            NovalnetGuaranteedSepaMethodProvider::class,
            NovalnetIdealMethodProvider::class,
            NovalnetAchMethodProvider::class,
            NovalnetInstalmentInvoiceMethodProvider::class,
            NovalnetInstalmentSepaMethodProvider::class,
            NovalnetInvoiceMethodProvider::class,
            NovalnetMultibancoMethodProvider::class,
            NovalnetPaypalMethodProvider::class,
            NovalnetPostfinanceCardMethodProvider::class,
            NovalnetPostfinanceMethodProvider::class,
            NovalnetPrepaymentMethodProvider::class,
            NovalnetPrzelewyMethodProvider::class,
            NovalnetSepaMethodProvider::class,
            NovalnetAlipayMethodProvider::class,
            NovalnetWechatpayMethodProvider::class,
            NovalnetOnlinebanktransferMethodProvider::class,
            NovalnetTrustlyMethodProvider::class,
            NovalnetKakaopayMethodProvider::class,
            NovalnetTwintMethodProvider::class,
            NovalnetMbwayMethodProvider::class,
            NovalnetPayconiqMethodProvider::class,
            NovalnetBlikMethodProvider::class,
            NovalnetNaverpayMethodProvider::class,
        ]);
    }
}
