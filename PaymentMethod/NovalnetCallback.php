<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod;

use Oro\Bundle\EmailBundle\Form\Model\Email;
use Symfony\Contracts\Translation\TranslatorInterface;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Oro\Bundle\EntityBundle\ORM\DoctrineHelper;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetHelper;
use Symfony\Component\HttpFoundation\RequestStack;
use Oro\Bundle\ConfigBundle\Config\ConfigManager;
use Oro\Bundle\EmailBundle\Sender\EmailModelSender;
use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetTransactionDetails;
use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetCallbackHistory;
use Oro\Bundle\PaymentBundle\Entity\PaymentTransaction;
use Psr\Log\LoggerInterface;
use Oro\Bundle\PaymentBundle\Method\Provider\PaymentMethodProviderInterface;
use Oro\Bundle\OrderBundle\Entity\Order;

/**
 * Novalnet Callback script
 */
class NovalnetCallback
{
    /**
     * @var TranslatorInterface
     */
    protected $translator;

    /**
     * @var DoctrineHelper
     */
    private $doctrineHelper;

    /**
     * @var Doctrine
     */
    private $doctrine;

    /**
     * @var RequestStack
     */
    private $requestStack;

    /**
     * @var Processor
     */
    private $emailModelSender;

    /**
     * @var ConfigManager
     */
    private $oroGlobalConfig;
    
    /**
     * @var NovalnetHelper
     */
    private $novalnetHelper;

    /**
     * @var PaymentTransaction
     */
    private $paymentTransaction;

    /**
     * @var object
     */
    protected $eventData;

    /**
     * @var int
     */
    protected $eventTid;

    /**
     * @var int
     */
    protected $parentTid;

    /**
     * @var object
     */
    protected $nnTransactionDetailEntity;

    /**
     * @var string
     */
    protected $customerNotes;

    /**
     * @var object
     */
    protected $orderReference;
    

    /**
     * Mandatory Parameters.
     *
     * @var array
     */
    protected $mandatory = [
        'event'       => [
            'type',
            'checksum',
            'tid',
        ],
        'merchant'    => [
            'vendor',
            'project',
        ],
        'result'      => [
            'status',
        ],
        'transaction' => [
            'tid',
            'payment_type',
            'status',
        ],
    ];




    /**
     * Constructor for initiate the callback process
     *
     * @param Registry doctrine
     * @param DoctrineHelper doctrineHelper
     * @param TranslatorInterface translator
     * @param NovalnetHelper novalnetHelper
     * @param ConfigManager oroGlobalConfig
     * @param Processor emailModelSender
     * @param RequestStack requestStack
     * @param LoggerInterface logger
     */
    public function __construct(
        Registry $doctrine,
        DoctrineHelper $doctrineHelper,
        TranslatorInterface $translator,
        NovalnetHelper $novalnetHelper,
        ConfigManager $oroGlobalConfig,
        EmailModelSender $emailModelSender,
        RequestStack $requestStack,
        LoggerInterface $logger
    ) {
        $this->qb = $doctrine->getManager();
        $this->doctrine = $doctrine;
        $this->doctrineHelper = $doctrineHelper;
        $this->translator = $translator;
        $this->novalnetHelper = $novalnetHelper;
        $this->oroGlobalConfig = $oroGlobalConfig;
        $this->emailModelSender = $emailModelSender;
        $this->requestStack = $requestStack->getCurrentRequest();
        $this->logger = $logger;
    }

    /**
     * Processes the callback script
     *
     * @param object $event
     * @param  object $paymentProvider
     * @return null
     */
    public function startProcess($event, $paymentProvider)
    {
        $this->paymentTransaction = $event->getPaymentTransaction();

        $paymentMethod = $paymentProvider->getPaymentMethod($this->paymentTransaction->getPaymentMethod());
        $novalnetGlobalConfig = $paymentMethod->config;

        // Authenticate request host.
        $authenticateResult = $this->authenticateEventData($novalnetGlobalConfig);
        if ($authenticateResult) {
            return $this->debugMessage($authenticateResult);
        }

        $orderDetailsEntity = $this->doctrineHelper->getEntity(
            $this->paymentTransaction->getEntityClass(),
            $this->paymentTransaction->getEntityIdentifier()
        );


        if (!empty($this->eventData['transaction']['order_no']) &&
        $orderDetailsEntity->getId() != $this->eventData['transaction']['order_no']) {
            return $this->debugMessage('Order reference not matching.');
        }

        $orderNo = !empty($this->eventData ['transaction'] ['order_no']) ? $this->eventData ['transaction'] ['order_no'] : $orderDetailsEntity->getId();

        // Get order reference.
        $isCommunicationFailure = $this->getOrderReference($orderNo);

        if ($isCommunicationFailure) {
            return;
        }
        
        if (! empty($this->eventData ['transaction'] ['order_no']) && $this->orderReference ['orderNo'] != $this->eventData ['transaction'] ['order_no']) {
            return $this->debugMessage('Order reference not matching.');
        }

        $repository = $this->doctrine->getRepository(NovalnetTransactionDetails::class);
        $this->nnTransactionDetailEntity = $repository->findOneBy(['orderNo' => $orderDetailsEntity->getId()]);
        
        $result = $this->handleTransactionEvents();
        if($result)
        {
            return $this->debugMessage($result);
        }
        
        // Update novalnet transaction details
        return $this->updateTransactionDetails($orderDetailsEntity, $novalnetGlobalConfig);
        
    }
    
    /**
     * Update Transaction Details and order comments
     * @return null
     */
    protected function updateTransactionDetails($orderDetailsEntity, $novalnetGlobalConfig)
    {
        $entityManager = $this->doctrineHelper->getEntityManager(NovalnetTransactionDetails::class);
        $entityManager->persist($this->nnTransactionDetailEntity);
        $entityManager->flush();

        if (!empty($this->customerNotes)) {
            $comments = ($orderDetailsEntity->getCustomerNotes())
                          ? $orderDetailsEntity->getCustomerNotes() . PHP_EOL . $this->customerNotes
                          : $this->customerNotes;

            $orderDetailsEntity->setCustomerNotes($comments);
            $this->debugMessage($this->customerNotes);
            
            $orderDetailsEm = $this->doctrineHelper->getEntityManager(Order::class);
            $orderDetailsEm->persist($orderDetailsEntity);
            $orderDetailsEm->flush($orderDetailsEntity);
            
            $this->sendNotificationMail($novalnetGlobalConfig, $orderDetailsEntity);
        }
    }
    
    /**
     * Handle Transaction Event
     * @return string|null
     */
    protected function handleTransactionEvents()
    {
        switch ($this->eventType) {
            case 'PAYMENT':
                return 'The Payment has been received';
                break;
            case 'TRANSACTION_CAPTURE':
            case 'TRANSACTION_CANCEL':
                $this->handleTransactionCaptureCancel();
                break;
            case 'TRANSACTION_REFUND':
                $this->handleTransactionRefund();
                break;
            case 'TRANSACTION_UPDATE':
                $this->handleTransactionUpdate();
                break;
            case 'CREDIT':
                $this->handleCredit();
                break;
            case 'CHARGEBACK':
                $this->handleChargeback();
                break;
            case 'INSTALMENT':
                $this->handleInstalment();
                break;
            case 'INSTALMENT_CANCEL':
				$this->handleInstalmentCancel();
				break;
            case 'PAYMENT_REMINDER_1':
            case 'PAYMENT_REMINDER_2':
				$this->handlePaymentReminder();
				break;
            case 'SUBMISSION_TO_COLLECTION_AGENCY':
				$this->handleCollection();
				break;
            default:
                return "default The webhook notification has been received for the unhandled EVENT type($this->event_type)";
        }
        return false;
    }

    /**
     * Handle Instalment payment
     * @return null
     */
    public function handleInstalment()
    {
        if ($this->eventData['transaction']['status'] == 'CONFIRMED' && ! empty($this->eventData['instalment']['cycles_executed'])) {
            $this->customerNotes = sprintf($this->translator->trans('novalnet.callback_instalment_cycle_executed'), $this->parentTid, $this->novalnetHelper->amountFormat($this->eventData['transaction']['amount']), date('d-m-Y'), $this->eventTid);
            
            $additionalInfo = (array) json_decode($this->orderReference['additionalInfo'], true);
            if($additionalInfo['cycle_dates']) {
				$additionalInfo[$this->eventData['instalment']['cycles_executed']] = ['tid' => $this->eventTid];
			}
			elseif($additionalInfo['instalmentDetails']) {
				$additionalInfo['instalmentDetails'][$this->eventData['instalment']['cycles_executed']] = ['tid' => $this->eventTid];	
			}
			
			if(isset($this->eventData['transaction']['bank_details']) && !empty($this->eventData['transaction']['bank_details']['qr_image']) && $additionalInfo['bank_details']) {
				$additionalInfo['bank_details']['qr_image'] = $this->eventData['transaction']['bank_details']['qr_image'];
			}
						
            $this->nnTransactionDetailEntity->setAdditionalInfo(json_encode($additionalInfo));
            
            if(empty($this->eventData['instalment']['prepaid']) && $this->eventData['transaction']['payment_type'] == 'INSTALMENT_INVOICE') {
                $this->customerNotes .= $this->novalnetHelper->prepareComments($this->eventData, $this->translator);
            }
            $this->prepareMailContent('instalment');
        }
    }
    
    /**
     * Handle Instalment Cancel
     * @return null
     */
    public function handleInstalmentCancel()
    {
		$additionalInfo = (array) json_decode($this->orderReference['additionalInfo'], true);
		
		$this->customerNotes = sprintf($this->translator->trans('novalnet.cancel_remaining_cycles_message'), $this->parentTid, date('d-m-Y'));
		$additionalInfo['instalmentDetails']['cancel_type'] = 'cancel_remaining_cycles';
		
		if($this->eventData['instalment']['cancel_type'] == 'ALL_CYCLES') {
			$this->customerNotes = sprintf($this->translator->trans('novalnet.cancel_all_cycles_message'), $this->parentTid, date('d-m-Y'));
			$additionalInfo['instalmentDetails']['cancel_type'] = 'cancel_all_cycles';
			$this->setPaymentStatus('canceled');
		}
		
		$this->nnTransactionDetailEntity->setAdditionalInfo(json_encode($additionalInfo));
		
	}
    
    /**
     * Handle PaymentReminder
     * @return null
     */
    public function handlePaymentReminder()
    {
		$noOfRemainder = preg_replace('/[^0-9]/', '', $this->eventType);
		$this->customerNotes = sprintf($this->translator->trans('novalnet.payment_remainder_text'), $noOfRemainder);
	}
	
    /**
     * Handle Collection
     * @return null
     */
    public function handleCollection()
    {
		$this->customerNotes = sprintf($this->translator->trans('novalnet.collection_submitted_text'), $this->eventData['collection']['reference']);
	}
	
    /**
     * Handle Credit event
     * @return null
     */
    public function handleCredit()
    {
        if ($this->eventData['transaction']['payment_type'] == 'ONLINE_TRANSFER_CREDIT') {
            $this->customerNotes = sprintf($this->translator->trans('novalnet.callback_online_transfer_credit_executed'), $this->novalnetHelper->amountFormat($this->eventData['transaction']['amount']), $this->eventData['transaction']['order_no']);
            $this->logCallbackDetails();
        } else {
            $this->customerNotes = sprintf($this->translator->trans('novalnet.callback_credit_executed'), $this->parentTid, $this->novalnetHelper->amountFormat($this->eventData['transaction']['amount']), date('d-m-Y'), $this->eventTid);

            if (in_array($this->eventData['transaction']['payment_type'], [ 'INVOICE_CREDIT', 'MULTIBANCO_CREDIT' ])) {
                $amountAlreadyPaid = $this->getOrderPaidAmount($this->parentTid);

                if ($amountAlreadyPaid < $this->nnTransactionDetailEntity->getAmount()) {
                    $totalPaidAmount = $amountAlreadyPaid + $this->eventData['transaction']['amount'];
                    $refundedAmount = ($this->nnTransactionDetailEntity->getRefundedAmount()) ? $this->nnTransactionDetailEntity->getRefundedAmount() : 0;
                    $amountToBePaid  = $this->nnTransactionDetailEntity->getAmount() - $refundedAmount;

                    if ($totalPaidAmount >= $amountToBePaid) {
                        $this->setPaymentStatus('full');
                        $this->nnTransactionDetailEntity->setStatus($this->eventData['transaction']['status']);
                    }
                    $this->logCallbackDetails();
                }
            }
        }
    }


    /**
     * Get the order paid amount from database
     *
     * @param integer $parentTid
     * @return integer
     */
    protected function getOrderPaidAmount($parentTid)
    {
        $repository = $this->doctrine->getRepository(NovalnetCallbackHistory::class);
        $qryBuilder = $repository->createQueryBuilder('nn')
            ->select('SUM(nn.callbackAmount) AS amount')
            ->where('nn.orgTid = :parentTid')
            ->andWhere('nn.paymentType IN (:paymentType)')
            ->setParameter('parentTid', $parentTid)
            ->setParameter('paymentType', ['INVOICE_CREDIT', 'MULTIBANCO_CREDIT']);
        $result = $qryBuilder->getQuery()->getArrayResult();
        return !empty($result[0]['amount']) ? $result[0]['amount'] : '0';
    }


    /**
     * Save Callback Details
     * @return null
     */
    protected function logCallbackDetails()
    {
        $entityManager = $this->doctrineHelper->getEntityManager(NovalnetCallbackHistory::class);
        $nnCallbackHistory = new NovalnetCallbackHistory();
        $nnCallbackHistory->setCallbackTid($this->eventTid);
        $nnCallbackHistory->setOrgTid($this->parentTid);
        $nnCallbackHistory->setCallbackAmount($this->eventData['transaction']['amount']);
        $nnCallbackHistory->setOrderNo($this->orderReference['eventOrderNo']);
        $nnCallbackHistory->setPaymentType($this->eventData['transaction']['payment_type']);
        $nnCallbackHistory->setEventType($this->eventType);
        $nnCallbackHistory->setDate(new \DateTime(date('Y-m-d H:i:s')));
        $entityManager->persist($nnCallbackHistory);
        $entityManager->flush();
    }

    /**
     * Send notify email after callback process
     * 
     * @param object $novalnetGlobalConfig
     * @return null
     */
    protected function sendNotificationMail($novalnetGlobalConfig, $orderDetailsEntity)
    {
        if (!empty($novalnetGlobalConfig->getCallbackEmailTo())) {
            $email = new Email();
            $sender = $this->oroGlobalConfig->get('oro_notification.email_notification_sender_email');
            $email->setFrom($sender);
            $email->setTo(explode(',', $novalnetGlobalConfig->getCallbackEmailTo()));
            $mailSubject = 'Novalnet Callback script notification - Order No : ' . $this->orderReference['eventOrderNo'];

            $email->setSubject($mailSubject);
            $email->setBody($this->customerNotes);
            $email->setOrganization($orderDetailsEntity->getCustomerUser()->getOrganization());
            try {
                $this->emailModelSender->send($email, $email->getOrigin());
            } catch (\Swift_SwiftException $exception) {
                self::debugMessage('unable to send email');
            }
        }
    }

    /**
     * Handle transaction update event
     * @return null
     */
    public function handleTransactionUpdate()
    {
        if (in_array($this->eventData['transaction']['status'], [ 'PENDING', 'ON_HOLD', 'CONFIRMED', 'DEACTIVATED' ])) {
            if ($this->eventData['transaction']['status'] == 'DEACTIVATED') {
                $this->customerNotes = sprintf($this->translator->trans('novalnet.transaction_cancelled'), date('d-m-Y'), date('H:i:s'));
                $this->nnTransactionDetailEntity->setStatus($this->eventData['transaction']['status']);
                $this->setPaymentStatus('canceled');
            } else {
                $this->nnTransactionDetailEntity->setStatus($this->eventData['transaction']['status']);

                if ($this->orderReference['status'] == 'PENDING' && $this->eventData['transaction']['status'] == 'ON_HOLD') {
                    $this->customerNotes = sprintf($this->translator->trans('novalnet.callback_pending_to_onhold'), $this->eventTid, date('d-m-Y'), date('H:i:s'));
                } elseif (in_array($this->orderReference['status'], ['PENDING', 'ON_HOLD'])) {
					
					if(in_array($this->orderReference['paymentType'], ['INSTALMENT_INVOICE', 'INSTALMENT_DIRECT_DEBIT_SEPA', 'INVOICE', 'PREPAYMENT', 'GUARANTEED_INVOICE'])) {
						$additionalInfo = (array) json_decode($this->orderReference['additionalInfo']);
						if(isset($this->eventData['transaction']['bank_details']) && !empty($this->eventData['transaction']['bank_details']['qr_image'])) {
							if(!$additionalInfo['bank_details']) {
								$additionalInfo['bank_details'] = $this->eventData['transaction']['bank_details'];
							}
						}
							
						if (in_array($this->orderReference['paymentType'], ['INSTALMENT_INVOICE', 'INSTALMENT_DIRECT_DEBIT_SEPA']) && isset($this->eventData['instalment'])) {
							$instalmentData = $this->eventData['instalment'];
							$instalmentData[$instalmentData['cycles_executed']] = ['tid' => $this->eventTid];
							$instalmentData['formatted_cycle_amount'] = sprintf('%0.2f', $instalmentData['cycle_amount']/100);
							$additionalInfo['instalmentDetails'] = $instalmentData;
						}
						
						$this->nnTransactionDetailEntity->setAdditionalInfo(json_encode($additionalInfo));
					}
                    
                    if($this->eventData['transaction']['due_date']) {
                        $this->customerNotes .= sprintf($this->translator->trans('novalnet.transaction_update_amount_due_date'), $this->novalnetHelper->amountFormat($this->eventData['transaction']['amount']) . $this->eventData['transaction']['currency'], $this->eventData['transaction']['due_date']);
                    } else {
                        $this->customerNotes .= sprintf($this->translator->trans('novalnet.transaction_update'), $this->parentTid, $this->novalnetHelper->amountFormat($this->eventData['transaction']['amount']) . $this->eventData['transaction']['currency']);
                    } 
                }
                
                if (in_array($this->eventData['transaction']['payment_type'], ['INSTALMENT_INVOICE', 'GUARANTEED_INVOICE', 'INVOICE', 'PREPAYMENT'])) {
                    $this->customerNotes = $this->novalnetHelper->prepareComments($this->eventData, $this->translator);
                }
                
                if(in_array($this->orderReference['status'], ['PENDING', 'ON_HOLD']) && $this->eventData['transaction']['status'] == 'CONFIRMED') {
					$this->setPaymentStatus('full');
					$this->prepareMailContent('payment_confirmation');
				}
				                
                $this->nnTransactionDetailEntity->setAmount($this->eventData['transaction']['amount']);
            }
            $this->logCallbackDetails();
        }
    }

    /**
     * Handle transaction chargeback event
     * @return null
     */
    public function handleChargeback()
    {
        if ($this->orderReference['status'] == 'CONFIRMED' && !empty($this->eventData['transaction']['amount'])) {
            $this->customerNotes = sprintf($this->translator->trans('novalnet.transaction_chargeback'), $this->parentTid, $this->novalnetHelper->amountFormat($this->eventData ['transaction'] ['amount']), date('d-m-Y H:i:s'), $this->eventTid);
            $this->logCallbackDetails();
        }
    }

    /**
     * Handle Transaction Refund Event
     * @return null
     */
    public function handleTransactionRefund()
    {
        if ($this->orderReference['status'] == 'CONFIRMED' && !empty($this->eventData['transaction']['refund']['amount'])) {
            $this->customerNotes = sprintf($this->translator->trans('novalnet.refund_with_parent_tid'), $this->eventData['transaction']['tid'], $this->novalnetHelper->amountFormat($this->eventData['transaction']['refund']['amount']), $this->eventData['transaction']['refund']['currency']);

            if (!empty($this->eventData['transaction']['refund']['tid'])) {
                $this->customerNotes = sprintf($this->translator->trans('novalnet.refund_with_child_tid'), $this->parentTid, $this->novalnetHelper->amountFormat($this->eventData['transaction']['refund']['amount']), $this->eventData['transaction']['refund']['currency'], $this->eventData['transaction']['refund']['tid']);
            }

            $this->nnTransactionDetailEntity->setRefundedAmount($this->orderReference['refundedAmount'] + $this->eventData ['transaction'] ['refund'] ['amount']);
            $this->nnTransactionDetailEntity->setStatus($this->eventData ['transaction']['status']);
            $this->logCallbackDetails();
        }
    }


    /**
     * Handle transaction capture/cancel
     * @return null
     */
    public function handleTransactionCaptureCancel()
    {
        if (in_array($this->orderReference['status'], ['ON_HOLD', 'PENDING'])) {
            $this->nnTransactionDetailEntity->setStatus($this->eventData['transaction']['status']);
            if ($this->eventType == 'TRANSACTION_CAPTURE') {
                $this->customerNotes = sprintf(
                    $this->translator->trans('novalnet.transaction_confirmed'),
                    date('d-m-Y'),
                    date('H:i:s')
                );
                if (in_array(
                    $this->orderReference['paymentType'],
                    ['INSTALMENT_INVOICE', 'INSTALMENT_DIRECT_DEBIT_SEPA']
                ) && $this->eventData['instalment']) {
                    $instalmentData = $this->eventData['instalment'];
                    $instalmentData[$instalmentData['cycles_executed']] = ['tid' => $this->eventTid];
                    $instalmentData['formatted_cycle_amount'] = sprintf('%0.2f', $instalmentData['cycle_amount']/100);
                    
                    $additionalInfo = (array) json_decode($this->orderReference['additionalInfo']);
                    $additionalInfo['instalmentDetails'] = $instalmentData;
                    $this->nnTransactionDetailEntity->setAdditionalInfo(json_encode($additionalInfo));
                }
                if (in_array(
                    $this->orderReference['paymentType'],
                    ['INVOICE', 'GUARANTEED_INVOICE', 'INSTALMENT_INVOICE']
                )) {
                    $this->customerNotes .= $this->novalnetHelper->prepareComments($this->eventData, $this->translator);
                }
                if ($this->orderReference['paymentType'] != 'INVOICE') {
                    $this->setPaymentStatus('full');
                }
                
                $this->prepareMailContent('payment_confirmation');
            } else {
                $this->customerNotes = sprintf(
                    $this->translator->trans('novalnet.transaction_cancelled'),
                    date('d-m-Y'),
                    date('H:i:s')
                );
                $this->setPaymentStatus('canceled');
            }
            $this->logCallbackDetails();
        }
    }

    /**
     * Authenticate event data
     *
     * @param boolean $novalnetGlobalConfig
     * @return string|void
     */
    protected function authenticateEventData($novalnetGlobalConfig)
    {
        $callbackTestMode = $novalnetGlobalConfig->getCallbackTestMode();
        $novalnetHostName = 'pay-nn.de';

        $novalnetHostIp = gethostbyname($novalnetHostName);
      
		if (empty($novalnetHostIp)) { 
			return 'Novalnet HOST IP missing';
		}

		$requestReceivedIp = $this->getRemoteAddress($novalnetHostIp);

        if (! empty($novalnetHostIp) && ! empty($requestReceivedIp)) {
            if ($novalnetHostIp !== $requestReceivedIp && empty($callbackTestMode)) {
                return "Unauthorised access from the IP $requestReceivedIp";
            }
        } else {
            return 'Unauthorised access from the IP. Host/recieved IP is empty';
        }
        
        $validateEventData = $this->validateEventData();

        if ($validateEventData) {
            return $validateEventData;
        }

        return $this->validateChecksum($novalnetGlobalConfig->getPaymentAccessKey());
    }

    /**
     * Validate event data
     * @return string
     */
    protected function validateEventData()
    {

        try {
            $this->eventData = json_decode(file_get_contents('php://input'), true);
        } catch (Exception $e) {
            return "Received data is not in the JSON format $e";
        }

        if (! empty($this->eventData ['custom'] ['shop_invoked'])) {
            return 'Process already handled in the shop.';
        }
        
        // Validate request parameters.
        foreach ($this->mandatory as $category => $parameters) {
            if (empty($this->eventData [ $category ])) {
                // Could be a possible manipulation in the notification data.
                return "Required parameter category($category) not received";
            }
            foreach ($parameters as $parameter) {
                if (empty($this->eventData [ $category ] [ $parameter ])) {
                    // Could be a possible manipulation in the notification data.
                    return "Required parameter($parameter) in the category($category) not received";
                } elseif (in_array($parameter, ['tid', 'parent_tid'])
                   && !preg_match('/^\d{17}$/', $this->eventData[$category][$parameter])) {
                    return "Invalid TID received in the category($category) not received $parameter";
                }
            }            
        }
    }

    /**
     * Get order reference
     * @return bool
     */
    protected function getOrderReference($orderNo)
    {
        if (! empty($orderNo)) {
            $repository = $this->doctrine->getRepository(NovalnetTransactionDetails::class);
            $qryBuilder = $repository->createQueryBuilder('nn')
                ->select('nn')
                ->where('nn.tid = :tid')
                ->setParameter('tid', $this->parentTid);
            $result = $qryBuilder->getQuery()->getArrayResult();
            $this->orderReference = !empty($result) ? $result[0] : $result;
            if (empty($this->orderReference)) {
				$this->orderReference['eventOrderNo'] = $orderNo;
                $this->handleCommunicationFailure();
                return true;
            }
            $this->orderReference['eventOrderNo'] = $orderNo;
        }
        return false;
    }

    /**
     * Handle Communication Failure
     * @return null
     */
    public function handleCommunicationFailure()
    {
        #handle success transaction
        if (! empty($this->eventData['result']['status']) &&  $this->eventData['result']['status'] == 'SUCCESS') {
            $this->novalnetHelper->completeNovalnetOrder(
                $this->eventData,
                $this->paymentTransaction,
                $this->translator,
                $this->doctrineHelper
            );
            $this->novalnetHelper->setOrderStatus($this->eventData['transaction']['status'], $this->paymentTransaction);
        }
    }

    /**
     * Validate Checksum
     * 
     * @param string $paymentAccessKey
     * @return null
     */
    protected function validateChecksum($paymentAccessKey)
    {
        $token = $this->eventData['event']['tid'] . $this->eventData['event']['type'] .
                 $this->eventData['result']['status'];

        if (isset($this->eventData ['transaction'] ['amount'])) {
            $token .= $this->eventData ['transaction'] ['amount'];
        }
        if (isset($this->eventData ['transaction'] ['currency'])) {
            $token .= $this->eventData ['transaction'] ['currency'];
        }
        if (! empty($paymentAccessKey)) {
            $token .= strrev($paymentAccessKey);
        }

        $generatedChecksum = hash('sha256', $token);

        if ( $generatedChecksum !== $this->eventData ['event'] ['checksum'] ) {
            return 'While notifying some data has been changed. The hash check failed';
        }
        
        // Set Event data.
        $this->eventType = $this->eventData ['event'] ['type'];
        $this->eventTid  = $this->eventData ['event'] ['tid'];
        $this->parentTid = $this->eventTid;
        if (! empty($this->eventData ['event'] ['parent_tid'])) {
            $this->parentTid = $this->eventData ['event'] ['parent_tid'];
        }
    }


    /**
     * Log the error message
     *
     * @param string $errorMsg
     * @return null
     */
    protected function debugMessage($errorMsg)
    {
        $errorMsg = 'message=' . $errorMsg;
        $this->logger->info($errorMsg);
        return;
    }
    
    
    protected function getRemoteAddress($novalnetHostIP)
	{
		$ip_keys = array('HTTP_X_FORWARDED_HOST', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_REAL_IP', 'HTTP_CLIENT_IP', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR');
		foreach ($ip_keys as $key) {
			if (array_key_exists($key, $_SERVER) === true) {
				if(in_array($key, ['HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED_HOST'])) {
					$forwardedIP = !empty($_SERVER[$key]) ? explode(',', $_SERVER[$key]) : [];
					if(in_array($novalnetHostIP, $forwardedIP)) {
						return $novalnetHostIP;
					} else {
						return $_SERVER[$key];
					}
				}
				return $_SERVER[$key];
			}
		}
	}


    /**
     * Set the Payment Status
     *
     * @param string $status
     * @return null
     */
    protected function setPaymentStatus($status)
    {
        if ($status == 'full') {
            $this->paymentTransaction
                     ->setSuccessful(true)
                     ->setActive(false);
        } elseif ($status == 'canceled') {
            $this->paymentTransaction
                     ->setSuccessful(false)
                     ->setActive(false);
        } elseif ($status == 'pending') {
            $this->paymentTransaction
                     ->setSuccessful(false)
                     ->setActive(true);
        }
    }
    
    protected function prepareMailContent($type) {
		$orderDetailsEntity = $this->doctrineHelper->getEntity(
            $this->paymentTransaction->getEntityClass(),
            $this->paymentTransaction->getEntityIdentifier()
        );
        $customerName = $orderDetailsEntity->getBillingAddress()->getFirstName() . ' ' .$orderDetailsEntity->getBillingAddress()->getLastName();
        $customerMail = $orderDetailsEntity->getCustomerUser()->getEmail();
        
        $orderNo = $this->eventData['transaction']['order_no'];
        $store = $orderDetailsEntity->getWebsite();
        $content = '';
		if($type == 'instalment') {
			$subject = "Instalment confirmation at $store order no: $orderNo";
			$header = "<h1>Hello, $customerName!</h1>";
			$content = "<p>The next instalment cycle have arrived for the instalment order $orderNo placed at the " . $store  .", kindly refer further details below <br>";
		}
		else {
			$header = "<h1>Hello, $customerName!</h1>";
			$subject = "Order confirmation at $store order no: $orderNo";
		}
		$content .= str_replace('|', '<br>', $this->customerNotes);

		$mailBody = "<body style='background:#F6F6F6; font-family:Verdana, Arial, Helvetica, sans-serif; font-size:14px; margin:0; padding:0;'><div style='width:55%;height:auto;margin: 0 auto;background:rgb(247, 247, 247);border: 2px solid rgb(223, 216, 216);border-radius: 5px;box-shadow: 1px 7px 10px -2px #ccc;'><div style='min-height: 150px;padding:20px;'><table cellspacing='0' cellpadding='0' border='0' width='100%'><tr>$header,</tr></br></br><tr>$content</tr></br></table></div><div style='width:100%;height:20px;background:#00669D;'></div></div></body>";
		
		$email = new Email();
		$sender = $this->oroGlobalConfig->get('oro_notification.email_notification_sender_email');
		$email->setFrom($sender);
		$email->setTo([$customerMail]);
		$email->setSubject($subject);
		$email->setType('html');
		$email->setBody($mailBody);
		$email->setOrganization($orderDetailsEntity->getCustomerUser()->getOrganization());
		try {
			$this->emailModelSender->send($email);
		} catch (\Swift_SwiftException $exception) {
			self::debugMessage('unable to send email');
		}
	}
}
