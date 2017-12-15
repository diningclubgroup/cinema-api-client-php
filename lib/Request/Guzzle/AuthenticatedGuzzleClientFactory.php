<?php

namespace DCG\Cinema\Request\Guzzle;

use DCG\Cinema\ActiveUserToken\ActiveUserTokenProvider;
use DCG\Cinema\Exception\UserNotAuthenticatedException;
use GuzzleHttp\ClientInterface as GuzzleClientInterface;

class AuthenticatedGuzzleClientFactory implements GuzzleClientFactoryInterface
{
    private $guzzleClientFactory;
    private $activeUserTokenProvider;

    /**
     * @param GuzzleClientFactoryInterface $guzzleClientFactory
     * @param ActiveUserTokenProvider $activeUserTokenProvider
     */
    public function __construct(
        GuzzleClientFactoryInterface $guzzleClientFactory,
        ActiveUserTokenProvider $activeUserTokenProvider
    ) {
        $this->guzzleClientFactory = $guzzleClientFactory;
        $this->activeUserTokenProvider = $activeUserTokenProvider;
    }

    /**
     * @param array $headers
     * @return GuzzleClientInterface
     * @throws UserNotAuthenticatedException
     */
    public function create(array $headers = []): GuzzleClientInterface
    {
        $userToken = $this->activeUserTokenProvider->getUserToken();
        if ($userToken === null) {
            throw new UserNotAuthenticatedException();
        }

        $headers['User-Token'] = $userToken->getToken();
        return $this->guzzleClientFactory->create($headers);
    }
}
