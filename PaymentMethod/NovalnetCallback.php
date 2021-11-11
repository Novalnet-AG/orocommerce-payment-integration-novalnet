<?php

namespace Novalnet\Bundle\NovalnetBundle\PaymentMethod;

use Oro\Bundle\EmailBundle\Form\Model\Email;
use Symfony\Component\Translation\TranslatorInterface;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Oro\Bundle\EntityBundle\ORM\DoctrineHelper;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\NovalnetHelper;
use Symfony\Component\HttpFoundation\RequestStack;
use Oro\Bundle\ConfigBundle\Config\ConfigManager;
use Oro\Bundle\EmailBundle\Mailer\Processor;
use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetTransactionDetails;
use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetCallbackHistory;
use Monolog\Logger;
use Monolog\Handler\StreamHandler;

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
    private $aryPayments = ['CREDITCARD', 'INVOICE_START', 'DIRECT_DEBIT_SEPA', 'GUARANTEED_DIRECT_DEBIT_SEPA',
        'GUARANTEED_INVOICE', 'PAYPAL', 'ONLINE_TRANSFER', 'IDEAL', 'EPS', 'GIROPAY', 'PRZELEWY24', 'CASHPAYMENT'];

    /**
     * Type of Chargebacks available - Level : 1
     *
     * @var array
     */
    private $aryChargebacks = ['RETURN_DEBIT_SEPA', 'CREDITCARD_BOOKBACK', 'CREDITCARD_CHARGEBACK',
        'REFUND_BY_BANK_TRANSFER_EU', 'PAYPAL_BOOKBACK', 'PRZELEWY24_REFUND', 'REVERSAL', 'CASHPAYMENT_REFUND',
        'GUARANTEED_INVOICE_BOOKBACK', 'GUARANTEED_SEPA_BOOKBACK'];

    /**
     * Type of Credit entry payment and Collections available - Level : 2
     *
     * @var array
     */
    private $aryCollection = ['INVOICE_CREDIT', 'CREDIT_ENTRY_CREDITCARD', 'CREDIT_ENTRY_SEPA', 'DEBT_COLLECTION_SEPA',
        'DEBT_COLLECTION_CREDITCARD', 'ONLINE_TRANSFER_CREDIT', 'CASHPAYMENT_CREDIT',
        'CREDIT_ENTRY_DE', 'DEBT_COLLECTION_DE'];

    /**
     * Types of payment available
     *
     * @var array
     */
    private $aPaymentTypes = [
        'CREDITCARD' => ['CREDITCARD', 'CREDITCARD_BOOKBACK', 'CREDITCARD_CHARGEBACK', 'CREDIT_ENTRY_CREDITCARD',
            'DEBT_COLLECTION_CREDITCARD'],
        'DIRECT_DEBIT_SEPA' => ['DIRECT_DEBIT_SEPA', 'GUARANTEED_SEPA_BOOKBACK', 'RETURN_DEBIT_SEPA', 'DEBT_COLLECTION_SEPA',
            'CREDIT_ENTRY_SEPA', 'REFUND_BY_BANK_TRANSFER_EU', 'GUARANTEED_DIRECT_DEBIT_SEPA'],
        'IDEAL' => ['IDEAL', 'REFUND_BY_BANK_TRANSFER_EU', 'ONLINE_TRANSFER_CREDIT', 'REVERSAL', 'CREDIT_ENTRY_DE',
            'DEBT_COLLECTION_DE'],
        'ONLINE_TRANSFER' => ['ONLINE_TRANSFER', 'REFUND_BY_BANK_TRANSFER_EU', 'ONLINE_TRANSFER_CREDIT', 'REVERSAL',
            'CREDIT_ENTRY_DE', 'DEBT_COLLECTION_DE'],
        'PAYPAL' => ['PAYPAL', 'PAYPAL_BOOKBACK'],
        'PREPAYMENT' => ['INVOICE_START', 'INVOICE_CREDIT', 'REFUND_BY_BANK_TRANSFER_EU'],
        'CASHPAYMENT' => ['CASHPAYMENT', 'CASHPAYMENT_CREDIT', 'CASHPAYMENT_REFUND'],
        'INVOICE' => ['INVOICE_START', 'INVOICE_CREDIT', 'GUARANTEED_INVOICE', 'REFUND_BY_BANK_TRANSFER_EU',
            'GUARANTEED_INVOICE_BOOKBACK', 'CREDIT_ENTRY_DE', 'DEBT_COLLECTION_DE'],
        'EPS' => ['EPS', 'ONLINE_TRANSFER_CREDIT', 'REFUND_BY_BANK_TRANSFER_EU', 'REVERSAL', 'CREDIT_ENTRY_DE',
            'DEBT_COLLECTION_DE'],
        'GIROPAY' => ['GIROPAY', 'ONLINE_TRANSFER_CREDIT', 'REFUND_BY_BANK_TRANSFER_EU', 'REVERSAL',
            'CREDIT_ENTRY_DE', 'DEBT_COLLECTION_DE'],
        'PRZELEWY24' => ['PRZELEWY24', 'PRZELEWY24_REFUND']];

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
    private $oroEmailProcessor;

    /**
     * @var ConfigManager
     */
    private $oroGlobalConfig;

    /**
     * @var NovalnetHelper
     */
    private $novalnetHelper;

    /**
     * @var paymentTransaction
     */
    private $paymentTransaction;

    /**
     * Constructor for initiate the callback process
     *
     * @param Registry doctrine
     * @param DoctrineHelper doctrineHelper
     * @param TranslatorInterface translator
     * @param NovalnetHelper novalnetHelper
     * @param ConfigManager oroGlobalConfig
     * @param Processor oroEmailProcessor
     * @param RequestStack requestStack
     * @return null
     */
    public function __construct(
        Registry $doctrine,
        DoctrineHelper $doctrineHelper,
        TranslatorInterface $translator,
        NovalnetHelper $novalnetHelper,
        ConfigManager $oroGlobalConfig,
        Processor $oroEmailProcessor,
        RequestStack $requestStack
    ) {
        $this->qb = $doctrine->getManager();
        $this->doctrine = $doctrine;
        $this->doctrineHelper = $doctrineHelper;
        $this->translator = $translator;
        $this->novalnetHelper = $novalnetHelper;
        $this->oroGlobalConfig = $oroGlobalConfig;
        $this->oroEmailProcessor = $oroEmailProcessor;
        $this->novalnetConfig = $this->novalnetHelper->getNovalnetConfig($this->doctrine);
        $this->requestStack = $requestStack->getCurrentRequest();
    }

    /**
     * Processes the callback script
     *
     * @param array $aryCaptureParams
     * @return null
     */
    public function startProcess($event, $logger)
    {
        $this->paymentTransaction = $event->getPaymentTransaction();
        $aryCaptureParams = $event->getData();
        $this->event = $event;
        $this->logger = $logger;

        // Validate the request params
        if (!self::validateCaptureParams($aryCaptureParams)) {
            return;
        }

        $nnCaptureParams = self::getCaptureParams($aryCaptureParams);
        
        $nntransHistory = self::getOrderReference($nnCaptureParams);

        //Check getOrderReference returns false value
        if (!$nntransHistory) {
            return;
        }

        $currency = isset($aryCaptureParams['currency'])
            ? $aryCaptureParams['currency'] : $nntransHistory['currency'];
        $callbacklogParams = [
            'callback_tid' => $aryCaptureParams['tid'],
            'org_tid' => $nntransHistory['tid'],
            'callback_amount' => $aryCaptureParams['amount'],
            'order_no' => $nntransHistory['orderNo'],
            'date' => date('Y-m-d H:i:s')
        ];

        if (in_array($aryCaptureParams['payment_type'], $this->aryPayments)) {
            self::availablePayments($nnCaptureParams, $nntransHistory, $callbacklogParams, $currency);
        } elseif (in_array($aryCaptureParams['payment_type'], $this->aryChargebacks)) {
            self::chargebackPayments($nnCaptureParams, $nntransHistory, $currency);
        } elseif (in_array($aryCaptureParams['payment_type'], $this->aryCollection)) {
            self::collectionsPayments($nnCaptureParams, $nntransHistory, $callbacklogParams, $currency);
        }
    }

    /**
     * Level 2 payment process
     *
     * @param array $nnCaptureParams
     * @param array $nntransHistory
     * @param array $callbacklogParams
     * @param string $currency
     * @return null
     */
    public function collectionsPayments($nnCaptureParams, $nntransHistory, $callbacklogParams, $currency)
    {
        // Credit entry payment and Collections available
        if ($nntransHistory['paid_amount'] < $nntransHistory['amount']
            && in_array(
                $nnCaptureParams['payment_type'],
                ['INVOICE_CREDIT', 'CASHPAYMENT_CREDIT', 'ONLINE_TRANSFER_CREDIT']
            )
        ) {
            $paidAmount = (empty($nntransHistory['paid_amount'])
                    ? 0 : $nntransHistory['paid_amount']) + $nnCaptureParams['amount'];
            $callbackComments = sprintf(
                $this->translator->trans('novalnet_callback.paid.message'),
                $nnCaptureParams['tid_payment'],
                sprintf('%.2f', $nnCaptureParams['amount'] / 100) . ' ' . $currency,
                date('d-m-Y'),
                date('H:i:s'),
                $nnCaptureParams['tid']
            );
            $this->setCallbackComments($callbackComments);
            $this->insertCallbackTable($callbacklogParams);
            if ($paidAmount >= $nntransHistory['amount']
                && $nnCaptureParams['payment_type'] != 'ONLINE_TRANSFER_CREDIT') {
                self::setPaymentStatus('full');
            }
            self::sendNotifyMail([
                'comments' => $callbackComments,
                'order_no' => $nntransHistory['orderNo'],
            ]);
            return self::debugMessage($callbackComments, $nntransHistory['orderNo']);
        } elseif ($nntransHistory['paid_amount'] >= $nntransHistory['amount']
            && in_array($nnCaptureParams['payment_type'], ['INVOICE_CREDIT', 'CASHPAYMENT_CREDIT',
                'ONLINE_TRANSFER_CREDIT'])) {
            return self::debugMessage('Novalnet callback received. Callback Script executed already. Refer Order :' .
                $nntransHistory['orderNo'], $nntransHistory['orderNo']);
        } else {
            $callbackComments = sprintf(
                $this->translator->trans('novalnet_callback.paid.message'),
                $nnCaptureParams['tid_payment'],
                sprintf('%.2f', $nnCaptureParams['amount'] / 100) . ' ' . $currency,
                date('d-m-Y'),
                date('H:i:s'),
                $nnCaptureParams['tid']
            );
            $this->setCallbackComments($callbackComments);
            self::sendNotifyMail([
                'comments' => $callbackComments,
                'order_no' => $nntransHistory['orderNo'],
            ]);
            // Log callback process
            $this->insertCallbackTable($callbacklogParams);
            return self::debugMessage($callbackComments, $nntransHistory['orderNo']);
        }
    }

    /**
     * Level 1 payment process
     *
     * @param array $nnCaptureParams
     * @param array $nntransHistory
     * @param string $currency
     * @return null
     */
    public function chargebackPayments($nnCaptureParams, $nntransHistory, $currency)
    {
        //Level 1 payments - Type of Chargebacks
        $chargebackComments = sprintf(
            $this->translator->trans('novalnet_callback.chargeback.message'),
            $nnCaptureParams['tid_payment'],
            sprintf('%.2f', $nnCaptureParams['amount'] / 100) . ' ' . $currency,
            date('d-m-Y'),
            date('H:i:s'),
            $nnCaptureParams['tid']
        );
        $bookbackComments = sprintf(
            $this->translator->trans('novalnet_callback.bookback.message'),
            $nnCaptureParams['tid_payment'],
            sprintf('%.2f', $nnCaptureParams['amount'] / 100) . ' ' .
            $currency,
            date('d-m-Y'),
            date('H:i:s'),
            $nnCaptureParams['tid']
        );

        $callbackComments = (in_array(
            $nnCaptureParams['payment_type'],
            ['PAYPAL_BOOKBACK',
                'CREDITCARD_BOOKBACK',
                'PRZELEWY24_REFUND',
                'GUARANTEED_INVOICE_BOOKBACK',
                'GUARANTEED_SEPA_BOOKBACK',
                'CASHPAYMENT_REFUND',
                'REFUND_BY_BANK_TRANSFER_EU']
        ))
            ? $bookbackComments : $chargebackComments;

        $this->setCallbackComments($callbackComments);
        // Send notification mail to Merchant
        self::sendNotifyMail(['comments' => $callbackComments, 'order_no' => $nntransHistory['orderNo']]);
        return self::debugMessage($callbackComments, $nnCaptureParams['order_no']);
    }

    /**
     * Initial level payment process
     *
     * @param array $nnCaptureParams
     * @param array $nntransHistory
     * @param array $callbacklogParams
     * @param string $currency
     * @return null
     */
    public function availablePayments($nnCaptureParams, $nntransHistory, $callbacklogParams, $currency)
    {
        if ($nnCaptureParams['payment_type'] == 'PAYPAL') {
            return self::handleInitialLevelPaypal($nnCaptureParams, $nntransHistory, $callbacklogParams, $currency);
        } elseif ($nnCaptureParams['payment_type'] == 'PRZELEWY24') {
            if ($nnCaptureParams['tid_status'] == '100') {
                if ($nntransHistory['paid_amount'] == 0) {
                    // Full Payment paid Update order status due to full payment
                    $callbackComments = sprintf(
                        $this->translator->trans('novalnet_callback.executed.message'),
                        $nnCaptureParams['tid'],
                        sprintf('%0.2f', $nnCaptureParams['amount'] / 100) . ' ' . $currency,
                        date('d-m-Y'),
                        date('H:i:s')
                    );
                    $status = ($nnCaptureParams['status'] == '100' && $nnCaptureParams['tid_status'] == '86')
                        ? 'pending' : 'full';

                    self::setPaymentStatus($status);

                    $this->setCallbackComments($callbackComments);

                    $this->insertCallbackTable($callbacklogParams);
                    $this->novalnetDbUpdate($nntransHistory['orderNo'], $nnCaptureParams['tid_status']);
                    self::sendNotifyMail(['comments' => $callbackComments, 'order_no' => $nntransHistory['orderNo']]);
                    return self::debugMessage($callbackComments, $nnCaptureParams['order_no']);
                } else {
                    return self::debugMessage("Novalnet callback received. Order already paid.", $nntransHistory['orderNo']);
                }
            } elseif ($nnCaptureParams['tid_status'] != '86') {
                $message = (($nnCaptureParams['status_message'])
                    ? $nnCaptureParams['status_message'] : (($nnCaptureParams['status_text'])
                        ? $nnCaptureParams['status_text'] : (($nnCaptureParams['status_desc'])
                            ? $nnCaptureParams['status_desc']
                            : $this->translator->trans('novalnet_callback.payment_not_success.message'))));
                $callbackComments = sprintf(
                    $this->translator->trans('novalnet_callback.przelewy24_cancel.message'),
                    $message
                );
                self::setPaymentStatus('declined');

                $this->setCallbackComments($callbackComments);
                $this->novalnetDbUpdate($nntransHistory['orderNo'], $nnCaptureParams['tid_status']);
                // Logcallback process
                $this->insertCallbackTable($callbacklogParams);
                // Send notification mail to Merchant
                self::sendNotifyMail(['comments' => $callbackComments, 'order_no' => $nntransHistory['orderNo']]);
                return self::debugMessage($callbackComments, $nnCaptureParams['order_no']);
            }
        } elseif (in_array(
            $nnCaptureParams['payment_type'],
            ['INVOICE_START', 'GUARANTEED_INVOICE', 'DIRECT_DEBIT_SEPA', 'GUARANTEED_DIRECT_DEBIT_SEPA', 'CREDITCARD']
        )
            && in_array($nntransHistory['gatewayStatus'], [75, 91, 99, 98])
            && in_array($nnCaptureParams['tid_status'], [91, 99, 100])
            && $nnCaptureParams['status'] == '100') {
            return self::handleInitialLevelPayments($nntransHistory, $nnCaptureParams);
        } else {
            return self::debugMessage('Novalnet callback received. Payment type ( ' . $nnCaptureParams['payment_type'] . ' ) is
                not applicable for this process!', $nntransHistory['orderNo']);
        }
    }


    /**
     * Validate the required params to process callback
     *
     * @param array $requestParam
     * @return null
     */
    public function validateCaptureParams($requestParam)
    {
        // Validate Authenticated IP
        $realHostIp = gethostbyname('pay-nn.de');
        if (empty($realHostIp)) {
            return self::debugMessage('Novalnet HOST IP missing');
        }
        $callerIp = $this->novalnetHelper->getIp($this->requestStack);
        if ($callerIp != $realHostIp && !$this->novalnetConfig['callback_testmode']) {
            return self::debugMessage('Unauthorised access from the IP [' . $callerIp . ']');
        }
        if (!array_filter($requestParam)) {
            return self::debugMessage('Novalnet callback received. No params passed over!');
        }
        $hParamsRequired = ['vendor_id', 'tid', 'payment_type', 'status', 'tid_status'];

        if (in_array($requestParam['payment_type'], array_merge($this->aryChargebacks, $this->aryCollection))) {
            array_push($hParamsRequired, 'tid_payment');
        }
        $error = '';
        foreach ($hParamsRequired as $v) {
            if (!isset($requestParam[$v]) || ($requestParam[$v] == '')) {
                $error .= 'Novalnet callback received. Required param (' . $v . ') missing! <br>';
            } elseif (in_array($v, ['tid', 'signup_tid', 'tid_payment'])
                && !preg_match('/^[0-9]{17}$/', $requestParam[$v])) {
                $error .= 'Novalnet callback received. TID [' . $requestParam[$v] . '] is not valid.';
            }
        }
        if (!empty($error)) {
            return self::debugMessage($error, '');
        }
        return true;
    }

    /**
     * Get order reference from the novalnet_transaction_detail table on shop database
     *
     * @param array $nnCaptureParams
     * @return array
     */
    public function getOrderReference($nnCaptureParams)
    {
        $repository = $this->doctrine->getRepository(NovalnetTransactionDetails::class);
        $qryBuilder = $repository->createQueryBuilder('nn')
            ->select('nn')
            ->where('nn.tid = :tid')
            ->setParameter('tid', $nnCaptureParams['shop_tid']);
        $result = $qryBuilder->getQuery()->getArrayResult();
        $nntransHistory = !empty($result) ? $result[0] : $result;

        $orderDetails = $this->doctrineHelper->getEntity(
            $this->paymentTransaction->getEntityClass(),
            $this->paymentTransaction->getEntityIdentifier()
        );

        if (empty($orderDetails)) {
			
            if (in_array($nnCaptureParams['status'], [100, 90])) {
				
                self::criticalMailComments($nnCaptureParams);
                return;
            }
        }
        
        if (empty($nntransHistory) && !empty($orderDetails->getId())) {
            return $this->handleCommunicationFailure($nnCaptureParams);
        }
        
        // check notify url
        if (!empty($this->paymentTransaction->getReference()) && ($nnCaptureParams['shop_tid'] != $this->paymentTransaction->getReference())) {
            return self::debugMessage('Novalnet Callback received Notify Url mismatched TID: ' . $this->paymentTransaction->getReference());
        }
        
        if ($nnCaptureParams['payment_type'] == 'TRANSACTION_CANCELLATION') {
            // transaction cancelled for invoice and sepa payments
            $callbackComments = sprintf(
                $this->translator->trans('novalnet_callback.trans_cancelled.message'),
                date('d-m-Y'),
                date('H:i:s')
            );
            $this->novalnetDbUpdate($nntransHistory['orderNo'], $nnCaptureParams['tid_status']);

            self::setPaymentStatus('declined');

            $this->setCallbackComments($callbackComments);
            self::sendNotifyMail(['comments' => $callbackComments, 'order_no' => $nntransHistory['orderNo']]);
            return self::debugMessage($callbackComments);
        }

        $paymentMethod = (in_array(
            $nntransHistory['paymentType'],
            ['GUARANTEED_INVOICE', 'GUARANTEED_DIRECT_DEBIT_SEPA']
        )
            ? str_replace('GUARANTEED_', '', $nntransHistory['paymentType'])
            : $nntransHistory['paymentType']);


        if (!empty($nnCaptureParams['order_no']) && $nntransHistory['orderNo'] != $nnCaptureParams['order_no']) {
            return self::debugMessage('Novalnet callback received. Order no is not valid', $nnCaptureParams['order_no']);
        } elseif ((!array_key_exists($paymentMethod, $this->aPaymentTypes))
            || !in_array($nnCaptureParams['payment_type'], $this->aPaymentTypes[$paymentMethod])) {
            return self::debugMessage(
                'Novalnet callback received. Payment type [' . $nnCaptureParams['payment_type'] . '] is mismatched!',
                $nnCaptureParams['order_no']
            );
        }

        $nntransHistory['paid_amount'] = $this->getOrderPaidAmount($nnCaptureParams['shop_tid']);
        $nntransHistory['customercomment'] = $orderDetails->getCustomerNotes();
        $nntransHistory['tid'] = $nnCaptureParams['shop_tid'];
        return $nntransHistory;
    }

    /**
     * Perform parameter validation process
     * Set empty value if not exist in aryCapture
     *
     * @param array $aryCapture
     * @return array
     */
    public function getCaptureParams($aryCapture = [])
    {
        $aryCapture['shop_tid'] = $aryCapture['tid'];
        if (in_array($aryCapture['payment_type'], array_merge($this->aryChargebacks, $this->aryCollection))) {
            // Collection Payments or Chargeback Payments
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
    protected function debugMessage($errorMsg, $orderNo = null)
    {
        if ($orderNo) {
            $errorMsg = 'message=' . $errorMsg . 'ordernumber=' . $orderNo;
        } else {
            $errorMsg = 'message=' . $errorMsg;
        }
        $this->logger->debug($errorMsg);
        $log = new Logger('novalnet');
        $log->pushHandler(new StreamHandler('../var/logs/novalnet.log', Logger::INFO));
        $log->addInfo($errorMsg);
        return;
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
            $this->paymentTransaction->setSuccessful(true);
            $this->paymentTransaction->setActive(false);
        } elseif ($status == 'declined') {
            $this->paymentTransaction->setSuccessful(false);
            $this->paymentTransaction->setActive(false);
        } elseif ($status == 'pending') {
            $this->paymentTransaction->setSuccessful(false);
            $this->paymentTransaction->setActive(true);
        }
    }

    /**
     * Get the order paid amount from database
     *
     * @param integer $tid
     * @return integer
     */
    public function getOrderPaidAmount($tid)
    {
        if (empty($tid)) {
            return null;
        }
        $repository = $this->doctrine->getRepository(NovalnetCallbackHistory::class);
        $qryBuilder = $repository->createQueryBuilder('nn')
            ->select('SUM(nn.callbackAmount) AS amount')
            ->where('nn.orgTid = :id')
            ->setParameter('id', $tid);
        $result = $qryBuilder->getQuery()->getArrayResult();
        return !empty($result[0]['amount']) ? $result[0]['amount'] : '0';
    }

    /**
     * Set payment status
     *
     * @param integer $orderNo
     * @param string $comments
     * @return null
     */
    public function setCallbackComments($comments)
    {
        $orderDetailsEntity = $this->doctrineHelper->getEntity(
            $this->paymentTransaction->getEntityClass(),
            $this->paymentTransaction->getEntityIdentifier()
        );
        $customerNotes = ($orderDetailsEntity->getCustomerNotes()) ?  $orderDetailsEntity->getCustomerNotes() . ' | ' . $comments : $comments;

        $orderDetailsEntity->setCustomerNotes($customerNotes);
        $entityManager = $this->doctrineHelper->getEntityManager('OroOrderBundle:Order');
        $entityManager->persist($orderDetailsEntity);
        $entityManager->flush($orderDetailsEntity);
    }

    /**
     * Save Callback details in callback history table
     *
     * @param array $data
     * @return null
     */
    protected function insertCallbackTable($data)
    {
		
        $em = $this->doctrineHelper->getEntityManager('NovalnetBundle:NovalnetCallbackHistory');
        $nnCallbackHistory = new NovalnetCallbackHistory();
        $nnCallbackHistory->setCallbackTid($data['callback_tid']);
        $nnCallbackHistory->setOrgTid($data['org_tid']);
        $nnCallbackHistory->setCallbackAmount($data['callback_amount']);
        $nnCallbackHistory->setOrderNo($data['order_no']);
        $nnCallbackHistory->setDate(new \DateTime($data['date']));
        $em->persist($nnCallbackHistory);
        $em->flush();
    }

    /**
     * Update Gatewaystatus in novalnet transaction table
     *
     * @param integer $orderNo
     * @param integer $gatewayStatus
     * @return null
     */
    public function novalnetDbUpdate($orderNo, $gatewayStatus)
    {
		
        $repository = $this->doctrine->getRepository(NovalnetTransactionDetails::class);
        $nnTransactionDetail = $repository->findOneBy(['orderNo' => $orderNo]);
        $nnTransactionDetail->setGatewayStatus($gatewayStatus);
        $em = $this->doctrineHelper->getEntityManager('NovalnetBundle:NovalnetTransactionDetails');
        $em->persist($nnTransactionDetail);
        $em->flush();
    }

    /**
     * Handle communication failure
     *
     * @param array $nnCaptureParams
     * @return null
     */
    public function handleCommunicationFailure($nnCaptureParams)
    {
		
        $paymentTypeVal = $nnCaptureParams['payment_type'] == 'INVOICE_START'
            ? strtolower($nnCaptureParams['invoice_type'])
            : (strtolower($nnCaptureParams['payment_type']) == 'ONLINE_TRANSFER_CREDIT' 
            ? 'online_transfer' : 
            strtolower($nnCaptureParams['payment_type']));



        $paymentType = $this->translator->trans('novalnet.payment_name_' . $paymentTypeVal);

        $newLine = ' | ';
        
        $callbackComments = $this->translator->trans('novalnet.payment_comment') . $newLine;
        $callbackComments .= $paymentType . $newLine;
        $callbackComments .= sprintf(
            $this->translator->trans('novalnet.transaction_id'),
            $nnCaptureParams['tid']
        ) . $newLine;

        if ($nnCaptureParams['test_mode'] == 1) { // If test transaction
            $callbackComments .= $this->translator->trans('novalnet.test_order') . $newLine;
        }
        if ((in_array($nnCaptureParams['status'], ['100', '90']))
            && in_array($nnCaptureParams['tid_status'], [100, 90, 85, 86, 91, 98, 99, 75])) {
            if ($nnCaptureParams['tid_status'] != 100
                || in_array($nnCaptureParams['payment_type'], ['INVOICE_START', 'CASHPAYMENT'])) {
                $status = 'pending';
            } else {
                $status = 'full';
            }
            self::setPaymentStatus($status);
            $callbackComments .= $this->novalnetHelper->prepareComments($nnCaptureParams, $this->translator);

            $this->novalnetHelper->insertNovalnetTransactionTable(
                $this->doctrine,
                $this->doctrineHelper,
                $nnCaptureParams
            );
            $this->setCallbackComments($callbackComments);
            return self::debugMessage($newLine . $callbackComments, $nnCaptureParams['order_no']);
        } else { // Handle failure transaction
            $callbackComments .= (($nnCaptureParams['status_message'])
                    ? $nnCaptureParams['status_message']
                    : (($nnCaptureParams['status_text'])
                        ? $nnCaptureParams['status_text']
                        : (($nnCaptureParams['status_desc'])
                            ? $nnCaptureParams['status_desc']
                            : $this->translator->trans('novalnet_callback.payment_not_success.message')))) . $newLine;
            $this->novalnetHelper->insertNovalnetTransactionTable(
                $this->doctrine,
                $this->doctrineHelper,
                $nnCaptureParams
            );
            self::setPaymentStatus('declined');

            $this->setCallbackComments($callbackComments);
            return self::debugMessage($callbackComments, $nnCaptureParams['order_no']);
        }
    }

    /**
     * Get mail values to send a comments
     *
     * @param array $nnCaptureParams
     * @return null
     */
    protected function criticalMailComments($nnCaptureParams)
    {
        $newLine = PHP_EOL;
        $orderNo = (isset($nnCaptureParams['order_no']) ? $nnCaptureParams['order_no'] : '');
        $comments = $newLine . 'Dear Technic team,' . $newLine . $newLine;
        $comments .= 'Please evaluate this transaction and contact our payment module team at Novalnet.' .
            $newLine . $newLine;
        $comments .= 'Merchant ID: ' . $nnCaptureParams['vendor_id'] . $newLine;
        $comments .= 'Project ID: ' . (isset($nnCaptureParams['product_id'])
                ? $nnCaptureParams['product_id']
                : '') . $newLine;
        $comments .= 'TID: ' . $nnCaptureParams['shop_tid'] . $newLine;
        $comments .= 'TID status: ' . $nnCaptureParams['tid_status'] . $newLine;
        $comments .= 'Order no: ' . $orderNo . $newLine;
        $comments .= 'Payment type: ' . $nnCaptureParams['payment_type'] . $newLine;
        $comments .= 'E-mail: ' . (isset($nnCaptureParams['email']) ? $nnCaptureParams['email'] : '') . $newLine;
        self::sendNotifyMail([
            'comments' => $comments,
            'tid' => $nnCaptureParams['shop_tid'],
            'order_no' => $orderNo
        ], true);
    }

    /**
     * Send notify email after callback process
     *
     * @param array $datas
     * @param boolean $missingTransactionNotify
     * @return null
     */
    protected function sendNotifyMail($datas, $missingTransNotify = false)
    {
        $email = new Email();
        $processor = $this->oroEmailProcessor;
        $sender = $this->oroGlobalConfig->get('oro_notification.email_notification_sender_email');
        $comments = '';
        $email->setFrom($sender);
        if ($missingTransNotify) { //This is only for missing transaction notification
            $mailSubject = 'Critical error on shop system order not found for TID: ' . $datas['tid'];
            $email->setTo(['technic@novalnet.de']);
            $email->setSubject($mailSubject);
            $email->setBody($datas['comments']);
            try {
                $processor->process($email);
            } catch (\Swift_SwiftException $exception) {
                self::debugMessage('unable to send email');
            }
        } elseif ($this->novalnetConfig['email_notification'] && !empty($this->novalnetConfig['email_to'])) {
            $email->setTo(explode(',', $this->novalnetConfig['email_to']));
            if (!empty($this->novalnetConfig['email_bcc'])) {
                $email->setBcc(explode(',', $this->novalnetConfig['email_bcc']));
            }
            $mailSubject = 'Novalnet Callback script notification - Order No : ' . $datas['order_no'];

            $email->setSubject($mailSubject);
            $email->setBody($datas['comments']);
            $processor = $this->oroEmailProcessor;
            ;
            try {
                $processor->process($email);
            } catch (\Swift_SwiftException $exception) {
                self::debugMessage('unable to send email');
            }
        }
    }

    /**
     * Handle initial level payments
     *
     * @param array $nnCaptureParams
     * @param array $nntransHistory
     * @return null
     */
    protected function handleInitialLevelPayments($nntransHistory, $nnCaptureParams)
    {
        $callbackComments = '';
        if (in_array($nnCaptureParams['tid_status'], [99, 91]) && $nntransHistory['gatewayStatus'] == 75) {
            $callbackComments = sprintf(
                $this->translator->trans('novalnet_callback.pending_to_onhold.message'),
                $nnCaptureParams['tid'],
                date('d-m-Y'),
                date('H:i:s')
            );
        } elseif ($nnCaptureParams['tid_status'] == 100
            && in_array($nntransHistory['gatewayStatus'], [75, 91, 99, 98])) {
            $callbackComments = sprintf(
                $this->translator->trans('novalnet_callback.trans_confirm.message'),
                date('d-m-Y'),
                date('H:i:s')
            );
            $status = ($nnCaptureParams['payment_type'] == 'INVOICE_START') ? 'pending' : 'full';
            self::setPaymentStatus($status);
        }
        if (!empty($callbackComments)) {
            if ($nntransHistory['gatewayStatus'] == '75'
                && $nnCaptureParams['payment_type'] == 'GUARANTEED_INVOICE') {
                $nnCaptureParams['amount'] = sprintf('%0.2f', $nnCaptureParams['amount'] / 100);
                $callbackComments .= $this->novalnetHelper->prepareComments($nnCaptureParams, $this->translator);
            }
            $this->setCallbackComments($callbackComments);
            $this->novalnetDbUpdate($nntransHistory['orderNo'], $nnCaptureParams['tid_status']);
            // Send notification mail to Merchant
            self::sendNotifyMail(['comments' => $callbackComments, 'order_no' => $nntransHistory['orderNo']]);
            return self::debugMessage($callbackComments, $nntransHistory['orderNo']);
        } else {
            return self::debugMessage(
                'Novalnet callback received. Payment type ( ' . $nnCaptureParams['payment_type'] . ' ) is
                not applicable for this process!',
                $nntransHistory['orderNo']
            );
        }
    }

    /**
     * Initial level Paypal Payment
     *
     * @param array $nnCaptureParams
     * @param array $nntransHistory
     * @return null
     */
    protected function handleInitialLevelPaypal($nnCaptureParams, $nntransHistory, $callbacklogParams, $currency)
    {
        if ($nnCaptureParams['tid_status'] == 100 && in_array($nntransHistory['gatewayStatus'], [85, 90])) {
            $callbackComments = sprintf(
                $this->translator->trans('novalnet_callback.executed.message'),
                $nnCaptureParams['tid'],
                sprintf('%0.2f', $nnCaptureParams['amount'] / 100) . ' ' . $currency,
                date('d-m-Y'),
                date('H:i:s')
            );
            $this->setCallbackComments($callbackComments);
            self::setPaymentStatus('full');
            $this->insertCallbackTable($callbacklogParams);
            $this->novalnetDbUpdate($nntransHistory['orderNo'], $nnCaptureParams['tid_status']);
            self::sendNotifyMail(['comments' => $callbackComments, 'order_no' => $nntransHistory['orderNo']]);
            return self::debugMessage($callbackComments, $nntransHistory['orderNo']);
        } else {
            return self::debugMessage('Novalnet callback received. Order already paid.', $nntransHistory['orderNo']);
        }
    }
}
