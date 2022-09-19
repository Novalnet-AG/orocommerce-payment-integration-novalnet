<?php

namespace Novalnet\Bundle\NovalnetBundle\Layout\DataProvider;

use Oro\Bundle\OrderBundle\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetTransactionDetails;

class NovalentTransactionDataProvider
{
    
    /**
     * @var Registry
     */
    private $doctrine;
    
    public function __construct(Registry $doctrine) {
        $this->doctrine = $doctrine;
    }
    
    /**
     * @param Order $order
     *
     * @return string
     */
    public function getTransactionDetails(Order $order)
    {
        $repository = $this->doctrine->getRepository(NovalnetTransactionDetails::class);
        $qryBuilder = $repository->createQueryBuilder('nn')
            ->select('nn')
            ->where('nn.orderNo = :orderNo')
            ->setParameter('orderNo', (string) $order->getId());
        $result = $qryBuilder->getQuery()->getArrayResult();
        $novalnetTransactionDetails = !empty($result) ? $result[0] : $result;
        if($novalnetTransactionDetails['additionalInfo']) {
            $instalmentDetails = json_decode($novalnetTransactionDetails['additionalInfo'], true);
            if($instalmentDetails['cycle_dates']) {
                $novalnetTransactionDetails['instalmentDetails'] = $instalmentDetails;
            }
        }
        $novalnetTransactionDetails['customerNotes'] = $order->getCustomerNotes();
        return $novalnetTransactionDetails;
    }
    
}
