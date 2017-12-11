<?php

namespace DCG\Cinema\Api\UserToken;

use DCG\Cinema\Request\ClientInterface;
use DCG\Cinema\Model\UserToken;

class UserTokenProvider
{
    private $client;
    private $userTokenFactory;

    public function __construct(
        ClientInterface $client,
        UserTokenFactory $userTokenFactory
    ) {
        $this->client = $client;
        $this->userTokenFactory = $userTokenFactory;
    }

    /**
     * Gets an access token from the remote API for the specified user ID.
     *
     * @param string $userId
     * @return UserToken
     * @throws \Exception
     */
    public function getToken($userId)
    {
        $clientResponse = $this->client->postUnauthenticated("users/{$userId}/tokens");
        return $this->userTokenFactory->createFromClientResponseData($clientResponse->getData());
    }
}
