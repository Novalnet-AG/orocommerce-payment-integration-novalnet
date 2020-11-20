<?php

namespace Novalnet\Bundle\NovalnetBundle\Client;

use Guzzle\Http\ClientInterface;

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
    public function send($hostAddress = '', $config = '', array $parameters = [])
    {
        $hostAddress = !empty($hostAddress) ? $hostAddress : 'https://paygate.novalnet.de/paygate.jsp';

        $response = $this->httpClient
            ->post($hostAddress, [], $parameters, $this->getRequestOptions($config))
            ->send();

        return $response->getBody(true);
    }

    /**
     * @param object $config
     * @return array
     */
    protected function getRequestOptions($config)
    {
        $requestOptions = [
            'timeout' => (!empty($config) && $config->getGatewayTimeout()) ? $config->getGatewayTimeout() : '240',
        ];

        return $requestOptions;
    }
}
