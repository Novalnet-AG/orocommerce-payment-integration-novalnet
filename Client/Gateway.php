<?php

namespace Novalnet\Bundle\NovalnetBundle\Client;

use GuzzleHttp\ClientInterface;

/**
 * Handle Novalnet payport API request and response
 */
class Gateway implements GatewayInterface
{
    /** @var ClientInterface */
    protected $httpClient;

    /**
     * @param ClientInterface $httpClient
     */
    public function __construct(ClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    /** {@inheritdoc} */
    public function send($paymentAccessKey, $parameters, $hostAddress)
    {   
        $encodedData = base64_encode($paymentAccessKey);
        $headers = [
            'Content-Type' => 'application/json',
            'charset' => 'utf-8',
            'Accept' => 'application/json',
            'X-NN-Access-Key' => $encodedData,
        ];
        
        $response = $this->httpClient->request(
            'POST', 
            $hostAddress, 
            $this->getRequestOptions($parameters, $headers)
         );
        $result = json_decode($response->getBody(true), true);
        return $result;
    }
    
    /**
     * @param object $config
     * @return array
     */
    protected function getRequestOptions($parameters, $headers)
    {
        $requestOptions = [
            'json' => $parameters,
            'headers' => $headers
        ];

        return $requestOptions;
    }
}
