<?php

namespace Novalnet\Bundle\NovalnetBundle\Controller;

use Oro\Bundle\SecurityBundle\Annotation\AclAncestor;
use Oro\Bundle\SecurityBundle\Annotation\CsrfProtection;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Novalnet\Bundle\NovalnetBundle\Client\Gateway;
/**
 * Novalnet Settings Controller
 */
class NovalnetSettingsController extends AbstractController
{
    /**
     * @Route(
     *      "/get-merchant-details",
     *      name="novalnet_settings_get_merchant_data",
     *      methods={"POST"}
     * )
     *
     * @AclAncestor("novalnet_settings_edit")
     * @CsrfProtection()
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function getMerchantDetailsAction(Request $request)
    {
        $paymentAccessKey = $request->get('privateKey');
        $productActivationKey = $request->get('publicKey');

        $data = ['merchant' => [
            'signature' => $productActivationKey
        ]];

        $client = $this->get(Gateway::class);
        $response = $client->send($paymentAccessKey, $data, 'https://payport.novalnet.de/v2/merchant/details');

        return new JsonResponse($response);
    }
    
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedServices()
    {
        return array_merge(parent::getSubscribedServices(), [
            Gateway::class
        ]);
    }
}
