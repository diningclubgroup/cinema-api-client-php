<?php

namespace DCG\Cinema\Request\Client;

use DCG\Cinema\ActiveUserToken\ActiveUserTokenProvider;
use DCG\Cinema\Exception\UserNotAuthenticatedException;
use DCG\Cinema\Request\ClientResponse;
use DCG\Cinema\Request\Guzzle\GuzzleClientFactoryInterface;
use DCG\Cinema\Request\RequestSender;

class AuthenticatedClient implements ClientInterface
{
    private $guzzleClientFactory;
    private $activeUserTokenProvider;
    private $requestSender;

    public function __construct(
        GuzzleClientFactoryInterface $guzzleClientFactory,
        ActiveUserTokenProvider $activeUserTokenProvider,
        RequestSender $requestSender
    ) {
        $this->guzzleClientFactory = $guzzleClientFactory;
        $this->activeUserTokenProvider = $activeUserTokenProvider;
        $this->requestSender = $requestSender;
    }

    /**
     * @inheritdoc
     */
    public function get(string $path, array $queryParams = [], array $successStatusCodes = [200]): ClientResponse
    {
        $guzzleClient = $this->guzzleClientFactory->create($this->requireUserToken());
        return $this->requestSender->sendRequest($guzzleClient, 'GET', $path, $queryParams, null, $successStatusCodes);
    }

    /**
     * @inheritdoc
     */
    public function post(string $path, string $body = null, array $successStatusCodes = [201]): ClientResponse
    {
        $guzzleClient = $this->guzzleClientFactory->create($this->requireUserToken());
        return $this->requestSender->sendRequest($guzzleClient, 'POST', $path, [], $body, $successStatusCodes);
    }

    /**
     * @inheritdoc
     */
    public function patch(string $path, string $body = null, array $successStatusCodes = [200]): ClientResponse
    {
        $guzzleClient = $this->guzzleClientFactory->create($this->requireUserToken());
        return $this->requestSender->sendRequest($guzzleClient, 'PATCH', $path, [], $body, $successStatusCodes);
    }

    private function requireUserToken()
    {
        $userToken = $this->activeUserTokenProvider->getUserToken();
        if (!$userToken) {
            throw new UserNotAuthenticatedException();
        }
        return $userToken;
    }
}