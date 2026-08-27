<?php

namespace Novalnet\Bundle\NovalnetBundle\Controller\Frontend;

use Oro\Bundle\CheckoutBundle\Entity\Checkout;
use Oro\Bundle\SecurityBundle\Attribute\AclAncestor;
use Oro\Bundle\SecurityBundle\Attribute\CsrfProtection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetTransactionDetails;
use Oro\Bundle\EntityBundle\ORM\DoctrineHelper;

/**
 * Ajax Novalnet Controller
 */
class AjaxNovalnetController extends AbstractController
{
    #[Route(
        path: '/remove-payment-data/{id}',
        name: 'novalnet_frontend_ajax_remove_payment_data',
        requirements: ['id' => '\d+'],
        methods: ['POST']
    )]
    public function removePaymentDataAction(
        #[MapEntity(id: 'id')] NovalnetTransactionDetails $novalnetTransactionDetails
    )
    {
        $success = true;
        try {
            $doctrineHelper = $this->get(DoctrineHelper::class);
            $novalnetTransactionDetails->setToken(null);
            $novalnetTransactionDetails->setPaymentData(null);
            $entityManager = $doctrineHelper->getEntityManager(NovalnetTransactionDetails::class);
            $entityManager->persist($novalnetTransactionDetails);
            $entityManager->flush();
        } catch (\Exception $exception) {
            $success = false;
        }

        return new JsonResponse(['successful' => $success]);
    }
    
    #[\Override]
    public static function getSubscribedServices(): array
    {
        return array_merge(parent::getSubscribedServices(), [
            DoctrineHelper::class
        ]);
    }
}
