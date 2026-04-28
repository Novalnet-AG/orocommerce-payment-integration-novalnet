<?php

namespace Novalnet\Bundle\NovalnetBundle\Layout\DataProvider;

use Oro\Bundle\OrderBundle\Entity\Order;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetTransactionDetails;


class NovalnetTransactionDataProvider
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
		$novalnetTransactionDetails = [];
		
        $repository = $this->doctrine->getRepository(NovalnetTransactionDetails::class);
        $qryBuilder = $repository->createQueryBuilder('nn')
            ->select('nn')
            ->where('nn.orderNo = :orderNo')
            ->setParameter('orderNo', (string) $order->getId());
        $result = $qryBuilder->getQuery()->getArrayResult();
        $result = !empty($result) ? $result[0] : $result;

        $novalnetTransactionDetails = $result;

        if($result['additionalInfo']) {
            $additionalInfo = json_decode($result['additionalInfo'], true);
            
            if(isset($additionalInfo['instalmentDetails']) || isset($additionalInfo['cycle_dates'])) {
				
				if($additionalInfo['cycle_dates']) {
					$novalnetTransactionDetails['instalmentDetails'] = $additionalInfo;
				}
				else {
					$novalnetTransactionDetails['instalmentDetails'] = $additionalInfo['instalmentDetails'];
				}

				if(!empty($novalnetTransactionDetails['instalmentDetails'])) {
					$cycleDates = $novalnetTransactionDetails['instalmentDetails']['cycle_dates'];
					ksort($cycleDates, SORT_NUMERIC);
					$novalnetTransactionDetails['instalmentDetails']['cycle_dates'] = $cycleDates;
				
					$totalCycles = count($novalnetTransactionDetails['instalmentDetails']['cycle_dates']);
					$lastCycleAmount = sprintf('%.2f', ($novalnetTransactionDetails['instalmentDetails']['total_amount']/100)) - ($novalnetTransactionDetails['instalmentDetails']['formatted_cycle_amount'] * ($totalCycles - 1));
				
					$novalnetTransactionDetails['instalmentDetails']['last_cycle_amount'] = $lastCycleAmount;
					$novalnetTransactionDetails['instalmentDetails']['total_cycles'] = $totalCycles;
				}
			}
          
            if ((in_array($result['paymentType'], ['INVOICE', 'PREPAYMENT']) ||  (in_array($result['paymentType'], ['GUARANTEED_INVOICE', 'INSTALMENT_INVOICE']) && !in_array($result['status'], ['PENDING', 'DEACTIVATED', 'FAILURE']))) && (isset($additionalInfo['bank_details']) && !empty($additionalInfo['bank_details']['qr_image']))) {
				$novalnetTransactionDetails['qrImage'] = $additionalInfo['bank_details']['qr_image'];
			}
        }
        
        return $novalnetTransactionDetails;
    }
}
