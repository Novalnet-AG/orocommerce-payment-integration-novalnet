<?php

namespace Novalnet\Bundle\NovalnetBundle\Datagrid;

use Doctrine\ORM\EntityManager;
use Oro\Bundle\DataGridBundle\Datasource\ResultRecordInterface;
use Oro\Bundle\PaymentBundle\Entity\PaymentTransaction;
use Oro\Bundle\PaymentBundle\Method\PaymentMethodInterface;
use Oro\Bundle\PaymentBundle\Method\Provider\PaymentMethodProviderInterface;
use Oro\Bundle\EntityBundle\ORM\DoctrineHelper;
use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetTransactionDetails;

/**
 * Displays Novalnet Extension options
 */
class ActionPermissionProvider
{
    /**
     * @var EntityManager
     */
    protected $manager;


    /**
     * @var DoctrineHelper
     */
    private $doctrineHelper;


    /**
     * ActionPermissionProvider constructor.
     * @param EntityManager $manager
     * @param DoctrineHelper $doctrineHelper
     */
    public function __construct(EntityManager $manager, DoctrineHelper $doctrineHelper)
    {
        $this->manager = $manager;
        $this->doctrineHelper = $doctrineHelper;
    }

    /**
     * Display Novalnet extension options
     * @param ResultRecordInterface $record
     * @return array
     */
    public function getActionPermissions(ResultRecordInterface $record): array
    {
        $paymentTransaction = $this->manager->getRepository(PaymentTransaction::class)->find($record->getValue('id'));

        $displayRefundOption = false;
        $displayManageTransactionOption = false;

        if ($paymentTransaction) {
            $paymentMethodName = $paymentTransaction->getPaymentMethod();
            if (strpos($paymentMethodName, 'novalnet') !== false) {
                $orderDetails = $this->doctrineHelper->getEntity(
                    $paymentTransaction->getEntityClass(),
                    $paymentTransaction->getEntityIdentifier()
                );

                $repository = $this->manager->getRepository(NovalnetTransactionDetails::class);

                $qryBuilder = $repository->createQueryBuilder('nn')
                    ->select('nn.paymentType, nn.status, nn.refundedAmount, nn.amount')
                    ->where('nn.orderNo = :orderNo')
                    ->setParameter('orderNo', (string) $orderDetails->getId());

                $transactionDetails = $qryBuilder->getQuery()->getArrayResult();
                $paymentType = $transactionDetails[0]['paymentType'];
                $status = $transactionDetails[0]['status'];
                $refundedAmount = $transactionDetails[0]['refundedAmount'];
                $orderAmount = $transactionDetails[0]['amount'];
                
                if ($status == 'ON_HOLD') {
                    $displayManageTransactionOption = true;
                }
                elseif(($status == 'CONFIRMED' || (in_array($paymentType, ['INVOICE', 'PREPAYMENT', 'CASHPAYMENT']) && $status == 'PENDING')) && $orderAmount > $refundedAmount) {
                    $displayRefundOption = true;
                }
            }
        }

        return [
            'refund' =>  $displayRefundOption,
            'manage_transaction' => $displayManageTransactionOption
        ];
    }
}
