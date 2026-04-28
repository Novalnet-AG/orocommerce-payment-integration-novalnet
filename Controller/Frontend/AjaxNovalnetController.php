<?php

namespace Novalnet\Bundle\NovalnetBundle\Controller\Frontend;

use Oro\Bundle\CheckoutBundle\Entity\Checkout;
use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use Oro\Bundle\SecurityBundle\Annotation\CsrfProtection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Novalnet\Bundle\NovalnetBundle\Entity\NovalnetTransactionDetails;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Oro\Bundle\EntityBundle\ORM\DoctrineHelper;

/**
 * Ajax Novalnet Controller
 */
class AjaxNovalnetController extends AbstractController
{
    /**
     * @Route(
     *      "/remove-payment-data/{id}",
     *      name="novalnet_frontend_ajax_remove_payment_data",
     *      requirements={"id"="\d+"},
     *      methods={"POST"}
     * )
     * @ParamConverter("paymentTransaction", class="NovalnetBundle:NovalnetTransactionDetails", options={"id" = "id"})
     * @param NovalnetTransactionDetails $novalnetTransactionDetails
     * @return JsonResponse
     */
    public function removePaymentDataAction(NovalnetTransactionDetails $novalnetTransactionDetails)
    {
        $success = true;
        try {
			$doctrineHelper = $this->get(DoctrineHelper::class);
            $novalnetTransactionDetails->setToken(null);
            $novalnetTransactionDetails->setPaymentData(null);
            $entityManager = $doctrineHelper->getEntityManager('NovalnetBundle:NovalnetTransactionDetails');
            $entityManager->persist($novalnetTransactionDetails);
            $entityManager->flush();
        } catch (\Exception $exception) {
            $success = false;
        }

        return new JsonResponse(['successful' => $success]);
    }
    
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedServices()
    {
        return array_merge(parent::getSubscribedServices(), [
            DoctrineHelper::class
        ]);
    }
}
