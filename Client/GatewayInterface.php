<?php

namespace Novalnet\Bundle\NovalnetBundle\Client;

/**
 * Interface for Handle Novalnet payport API request and response
 */
interface GatewayInterface
{
    /**
     * @param string $paymentAccessKey
     * @param array $parameters
     * @param string $hostAddress
     */
    public function send($paymentAccessKey, $parameters, $hostAddress);
}
