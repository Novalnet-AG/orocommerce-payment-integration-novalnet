<?php

namespace Novalnet\Bundle\NovalnetBundle\Controller;

use Oro\Bundle\PaymentBundle\Entity\PaymentTransaction;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Oro\Bundle\SecurityBundle\Annotation\CsrfProtection;
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
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider\NovalnetBanktransferMethodProvider;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider\NovalnetCashpaymentMethodProvider;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider\NovalnetCreditCardMethodProvider;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider\NovalnetEpsMethodProvider;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider\NovalnetGiropayMethodProvider;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider\NovalnetGuaranteedInvoiceMethodProvider;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider\NovalnetGuaranteedSepaMethodProvider;
use Novalnet\Bundle\NovalnetBundle\PaymentMethod\Provider\NovalnetIdealMethodProvider;
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

/**
 * Novalnet Extension Controller
 */
class NovalnetExtensionController extends AbstractController
{
    /**
     * @Route(
     *       "/show-manage-transaction/{paymentTransactionId}/",
     *       name="novalnet_transaction_show_manage_transaction"
     * )
     * @ParamConverter(
     *       "paymentTransaction",
     *        class="OroPaymentBundle:PaymentTransaction",
     *        options={"id" = "paymentTransactionId"}
     * )
     * @Template
     */
    public function showManageTransactionAction(PaymentTransaction $paymentTransaction)
    {
        $transactionDetails = $this->getNovalnetTransactionDetails($paymentTransaction);

        return ['transactionDetails' => $transactionDetails];
    }


    /**
     * @Route(
     *      "/show-refund/{paymentTransactionId}/",
     *       name="novalnet_transaction_show_refund"
     * )
     * @ParamConverter(
     *      "paymentTransaction",
     *      class="OroPaymentBundle:PaymentTransaction",
     *      options={"id" = "paymentTransactionId"}
     * )
     * @Template
     */
    public function showRefundAction(PaymentTransaction $paymentTransaction)
    {
        $transactionDetails = $this->getNovalnetTransactionDetails($paymentTransaction);
        return ['transactionDetails' => $transactionDetails];
    }


    /**
     * @Route(
     *     "/execute-refund",
     *      name="novalnet_transaction_execute_refund",
     *      methods={"POST"}
     * )
     * @CsrfProtection()
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function executeRefundAction(Request $request)
    {

        $tid = $request->get('tid');
        $amount = $request->get('amount');
        $reason = $request->get('reason');
        $paymentAccessKey = $request->get('paymentAccessKey');
        $paymentTransactionID = $request->get('paymentTransactionID');

        $data = [];

        // Build Merchant Data
        $data['transaction'] = [

            // the TID which need to be refund
            'tid'    => $tid,

            // The refund amount
            'amount' => $amount,
        ];
        $data['custom'] = [
            'shop_invoked' => 1
        ];
        
        if(!empty($reason))
        {
            $data['transaction']['reason'] = $reason;
        }
        $client = $this->get(Gateway::class);
        $response = $client->send($paymentAccessKey, $data, 'https://payport.novalnet.de/v2/transaction/refund');


        if ($response['result']['status_code'] == 100) {
            $repository = $this->getDoctrine()->getRepository(NovalnetTransactionDetails::class);
            $nnTransactionDetail = $repository->findOneBy(['tid' => $tid]);

            $orderRepository = $this->getDoctrine()->getRepository(Order::class);
            $orderDetails = $orderRepository->findOneBy(['id' => $nnTransactionDetail->getOrderNo()]);

            $novalnetHelper = $this->get(NovalnetHelper::class);
            $doctrineHelper = $this->get(DoctrineHelper::class);
            $translator = $this->get(TranslatorInterface::class);
            $paymentTransaction = $this->getDoctrine()->getRepository(PaymentTransaction::class)->findOneBy([
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

            $novalnetHelper->updateOrderComments($orderDetails, $doctrineHelper, $comments);
            $novalnetHelper->setOrderStatus($response['transaction']['status'], $paymentTransaction);

            $paymentTransactionProvider = $this->get(PaymentTransactionProvider::class);
            $paymentTransactionProvider->savePaymentTransaction($paymentTransaction);

            $refundedAmount = $nnTransactionDetail->getRefundedAmount() + $response['transaction']['refund']['amount'];

            $nnTransactionDetail->setRefundedAmount($refundedAmount);
            $nnTransactionDetail->setStatus($response['transaction']['status']);

            $entityManager = $doctrineHelper->getEntityManager('NovalnetBundle:NovalnetTransactionDetails');

            $entityManager->persist($nnTransactionDetail);
            $entityManager->flush();
        }


        return new JsonResponse($response);
    }

    /**
     * @Route(
     *    "/execute-manage-transaction",
     *     name="novalnet_transaction_execute_manage_transaction",
     *     methods={"POST"}
     * )
     * @CsrfProtection()
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function executeManageTransactionAction(Request $request)
    {
        $tid = $request->get('tid');
        $action = $request->get('transactionAction');
        $paymentAccessKey = $request->get('paymentAccessKey');
        $paymentTransactionID = $request->get('paymentTransactionID');

        $data = [];

        // Build Merchant Data
        $data['transaction'] = [

            // The TID which need to be captured
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
        }

        $client = $this->get(Gateway::class);

        $response = $client->send($paymentAccessKey, $data, $url);


        if ($response['result']['status_code'] == 100) {
            $repository = $this->getDoctrine()->getRepository(NovalnetTransactionDetails::class);
            $nnTransactionDetail = $repository->findOneBy(['tid' => $tid]);

            $novalnetHelper = $this->get(NovalnetHelper::class);
            $doctrineHelper = $this->get(DoctrineHelper::class);
            $translator = $this->get(TranslatorInterface::class);
            
            $nnTransactionDetail->setStatus($response['transaction']['status']);
            $entityManager = $doctrineHelper->getEntityManager('NovalnetBundle:NovalnetTransactionDetails');
            $entityManager->persist($nnTransactionDetail);
            $entityManager->flush();

            $orderRepository = $this->getDoctrine()->getRepository(Order::class);
            $orderDetails = $orderRepository->findOneBy(['id' => $nnTransactionDetail->getOrderNo()]);

            $paymentTransaction = $this->getDoctrine()->getRepository(PaymentTransaction::class)->findOneBy([
                    'id' =>  $paymentTransactionID
            ]);
       
            $comments = sprintf(
                $translator->trans('novalnet.transaction_confirmed'),
                date('d-m-Y'),
                date('H:i:s')
            );

            if (in_array($response['transaction']['status'], ['DEACTIVATED', 'FAILURE'])) {
                $comments =  ($action == 'instalment_cancel') ? sprintf(
                    $translator->trans('novalnet.instalment_cancel_text'), $tid) : sprintf(
                    $translator->trans('novalnet.transaction_cancelled'),
                    date('d-m-Y'),
                    date('H:i:s')
                );
            } elseif ($nnTransactionDetail->getPaymentType() == 'PAYPAL') {
                $paymentData = ['paypal_account' => $response['transaction']['payment_data']['paypal_account']];
                $nnTransactionDetail->setPaymentData(json_encode($paymentData));
            }
            
            if($response['transaction']['status'] == 'CONFIRMED' && !empty($response['transaction']['bank_details'])) {
                $novalnetHelper->prepareInvoiceComments($translator, $comments, $response);
            }

            $novalnetHelper->setOrderStatus($response['transaction']['status'], $paymentTransaction);
            $paymentTransactionProvider = $this->get(PaymentTransactionProvider::class);
            $paymentTransactionProvider->savePaymentTransaction($paymentTransaction);

            $novalnetHelper->updateOrderComments($orderDetails, $doctrineHelper, $comments);
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
        $doctrineHelper = $this->get(DoctrineHelper::class);
        $order = $doctrineHelper->getEntity(
            $paymentTransaction->getEntityClass(),
            $paymentTransaction->getEntityIdentifier()
        );

        $paymentCode = preg_replace('/_[0-9]{1,}$/', '', $paymentTransaction->getPaymentMethod());
        
        $paymentProviderNamespace = ' Novalnet\/Bundle\/NovalnetBundle\/PaymentMethod\/Provider\/';
        $paymentProviderNamespace = str_replace('/', '', $paymentProviderNamespace);
        $paymentProviderClass = str_replace(' ', '', ucwords(str_replace('_', ' ', $paymentCode)));
        
        $paymentProvider = $this->get(trim($paymentProviderNamespace.$paymentProviderClass.'MethodProvider'));
        $paymentMethod = $paymentProvider->getPaymentMethod($paymentTransaction->getPaymentMethod());
		
        $paymentAccessKey = $paymentMethod->config->getPaymentAccessKey();

        $repository = $this->getDoctrine()->getRepository(NovalnetTransactionDetails::class);

        $qryBuilder = $repository->createQueryBuilder('nn')
            ->select('nn.tid, nn.amount, nn.paymentType, nn.additionalInfo, nn.status')
            ->where('nn.orderNo = :orderNo')
            ->setParameter('orderNo', (string) $order->getId());

        $transactionDetails = $qryBuilder->getQuery()->getArrayResult();
        $transactionDetails[0]['instalmentDetails'] = [];
        if($transactionDetails[0]['additionalInfo']) {
            $transactionDetails[0]['instalmentDetails'] = json_decode($transactionDetails[0]['additionalInfo'], true);
        }
        $transactionDetails[0]['paymentAccessKey'] = $paymentAccessKey;
        $transactionDetails[0]['paymentTransactionID'] = $paymentTransaction->getId();

        return $transactionDetails[0];
    }
    
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedServices()
    {
		
        return array_merge(parent::getSubscribedServices(), [
            DoctrineHelper::class,
            Gateway::class,
            NovalnetHelper::class,
            TranslatorInterface::class,
            PaymentTransactionProvider::class,
            NovalnetCreditCardMethodProvider::class,
            NovalnetBancontactMethodProvider::class,
            NovalnetBanktransferMethodProvider::class,
            NovalnetCashpaymentMethodProvider::class,
            NovalnetEpsMethodProvider::class,
            NovalnetGiropayMethodProvider::class,
            NovalnetGuaranteedInvoiceMethodProvider::class,
            NovalnetGuaranteedSepaMethodProvider::class,
            NovalnetIdealMethodProvider::class,
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
            NovalnetTrustlyMethodProvider::class
        ]);
    }
}
