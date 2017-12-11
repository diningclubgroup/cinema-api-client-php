<?php

namespace DCG\Cinema\Request;

use DCG\Cinema\ActiveUserToken\ActiveUserTokenProvider;
use DCG\Cinema\Exception\UserNotAuthenticatedException;

class Client implements ClientInterface
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
    public function get($path, $queryParams = [], $successStatusCodes = [200])
    {
        $userToken = $this->activeUserTokenProvider->getUserToken();
        if (!$userToken) {
            throw new UserNotAuthenticatedException();
        }

        $guzzleClient = $this->guzzleClientFactory->create($userToken);
        return $this->requestSender->sendRequest($guzzleClient, 'GET', $path, $queryParams, null, $successStatusCodes);
    }

    /**
     * @inheritdoc
     */
    public function post($path, $body = null, $successStatusCodes = [201])
    {
        $userToken = $this->activeUserTokenProvider->getUserToken();
        if (!$userToken) {
            throw new UserNotAuthenticatedException();
        }

        $guzzleClient = $this->guzzleClientFactory->create($userToken);
        return $this->requestSender->sendRequest($guzzleClient, 'POST', $path, [], $body, $successStatusCodes);
    }

    /**
     * @inheritdoc
     */
    public function patch($path, $body = null, $successStatusCodes = [200])
    {
        $userToken = $this->activeUserTokenProvider->getUserToken();
        if (!$userToken) {
            throw new UserNotAuthenticatedException();
        }

        $guzzleClient = $this->guzzleClientFactory->create($userToken);
        return $this->requestSender->sendRequest($guzzleClient, 'PATCH', $path, [], $body, $successStatusCodes);
    }

    /**
     * @inheritdoc
     */
    public function getUnauthenticated($path, $queryParams = [], $successStatusCodes = [200])
    {
        $guzzleClient = $this->guzzleClientFactory->createUnauthenticated();
        return $this->requestSender->sendRequest($guzzleClient, 'GET', $path, $queryParams, null, $successStatusCodes);
    }

    /**
     * @inheritdoc
     */
    public function postUnauthenticated($path, $body = null, $successStatusCodes = [201])
    {
        $guzzleClient = $this->guzzleClientFactory->createUnauthenticated();
        return $this->requestSender->sendRequest($guzzleClient, 'POST', $path, [], $body, $successStatusCodes);
    }
}
