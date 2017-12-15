<?php

namespace DCG\Cinema\Request\Client;

use DCG\Cinema\Request\ClientResponse;
use DCG\Cinema\Request\Guzzle\GuzzleClientFactoryInterface;
use DCG\Cinema\Request\RequestSender;

class Client implements ClientInterface
{
    private $guzzleClientFactory;
    private $requestSender;

    public function __construct(
        GuzzleClientFactoryInterface $guzzleClientFactory,
        RequestSender $requestSender
    ) {
        $this->guzzleClientFactory = $guzzleClientFactory;
        $this->requestSender = $requestSender;
    }

    /**
     * @inheritdoc
     */
    public function get(string $path, array $queryParams = [], array $successStatusCodes = [200]): ClientResponse
    {
        $guzzleClient = $this->guzzleClientFactory->create();
        return $this->requestSender->sendRequest($guzzleClient, 'GET', $path, $queryParams, null, $successStatusCodes);
    }

    /**
     * @inheritdoc
     */
    public function post(string $path, string $body = null, array $successStatusCodes = [201]): ClientResponse
    {
        $guzzleClient = $this->guzzleClientFactory->create();
        return $this->requestSender->sendRequest($guzzleClient, 'POST', $path, [], $body, $successStatusCodes);
    }

    /**
     * @inheritdoc
     */
    public function patch(string $path, string $body = null, array $successStatusCodes = [200]): ClientResponse
    {
        $guzzleClient = $this->guzzleClientFactory->create();
        return $this->requestSender->sendRequest($guzzleClient, 'PATCH', $path, [], $body, $successStatusCodes);
    }
}