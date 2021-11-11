<?php

namespace Novalnet\Bundle\NovalnetBundle\Client;

/**
 * Interface for Handle Novalnet payport API request and response
 */
interface GatewayInterface
{
    /**
     * @param string $hostAddress
     * @param object $config
     * @param array $parameters
     */
    public function send($hostAddress, $config, array $parameters = []);
}
