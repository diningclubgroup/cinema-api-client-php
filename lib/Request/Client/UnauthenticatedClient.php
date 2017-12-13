<?php

namespace DCG\Cinema\Request\Client;

use DCG\Cinema\Request\Guzzle\GuzzleClientFactoryInterface;
use DCG\Cinema\Request\RequestSender;

class UnauthenticatedClient implements ClientInterface
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
    public function get($path, $queryParams = [], $successStatusCodes = [200])
    {
        $guzzleClient = $this->guzzleClientFactory->createUnauthenticated();
        return $this->requestSender->sendRequest($guzzleClient, 'GET', $path, $queryParams, null, $successStatusCodes);
    }

    /**
     * @inheritdoc
     */
    public function post($path, $body = null, $successStatusCodes = [201])
    {
        $guzzleClient = $this->guzzleClientFactory->createUnauthenticated();
        return $this->requestSender->sendRequest($guzzleClient, 'POST', $path, [], $body, $successStatusCodes);
    }

    /**
     * @inheritdoc
     */
    public function patch($path, $body = null, $successStatusCodes = [200])
    {
        $guzzleClient = $this->guzzleClientFactory->createUnauthenticated();
        return $this->requestSender->sendRequest($guzzleClient, 'PATCH', $path, [], $body, $successStatusCodes);
    }
}