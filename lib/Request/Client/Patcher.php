<?php

namespace DCG\Cinema\Request\Client;

use DCG\Cinema\Exception\UnexpectedResponseContentException;
use DCG\Cinema\Exception\UnexpectedStatusCodeException;
use DCG\Cinema\Exception\UserNotAuthenticatedException;
use DCG\Cinema\Request\ClientResponse;
use DCG\Cinema\Request\Guzzle\GuzzleClientFactoryInterface;
use DCG\Cinema\Request\RequestSender;

class Patcher
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
     * @param string $path
     * @param string|null $body
     * @param int[] $successStatusCodes
     * @return ClientResponse
     * @throws UserNotAuthenticatedException
     * @throws UnexpectedStatusCodeException
     * @throws UnexpectedResponseContentException
     * @throws \Exception
     */
    public function patch(string $path, string $body = null, array $successStatusCodes = [200]): ClientResponse
    {
        $guzzleClient = $this->guzzleClientFactory->create();
        return $this->requestSender->sendRequest($guzzleClient, 'PATCH', $path, [], $body, $successStatusCodes);
    }
}
