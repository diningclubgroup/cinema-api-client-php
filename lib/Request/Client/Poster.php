<?php

namespace DCG\Cinema\Request\Client;

use DCG\Cinema\Exception\UnexpectedResponseContentException;
use DCG\Cinema\Exception\UnexpectedStatusCodeException;
use DCG\Cinema\Exception\UserNotAuthenticatedException;
use DCG\Cinema\Request\ClientResponse;
use DCG\Cinema\Request\Guzzle\GuzzleClientFactoryInterface;
use DCG\Cinema\Request\RequestSender;

class Poster
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
    public function post(string $path, string $body = null, array $successStatusCodes = [201]): ClientResponse
    {
        $guzzleClient = $this->guzzleClientFactory->create();
        return $this->requestSender->sendRequest($guzzleClient, 'POST', $path, [], $body, $successStatusCodes);
    }
}
