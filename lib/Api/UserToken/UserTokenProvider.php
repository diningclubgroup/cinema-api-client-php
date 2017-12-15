<?php

namespace DCG\Cinema\Api\UserToken;

use DCG\Cinema\Model\UserToken;
use DCG\Cinema\Request\Client\Poster;

class UserTokenProvider
{
    private $poster;
    private $userTokenFactory;

    public function __construct(
        Poster $poster,
        UserTokenFactory $userTokenFactory
    ) {
        $this->poster = $poster;
        $this->userTokenFactory = $userTokenFactory;
    }

    /**
     * Gets an access token from the remote API for the specified user ID.
     *
     * @param string $userId
     * @return UserToken
     * @throws \Exception
     */
    public function getToken(string $userId): UserToken
    {
        $clientResponse = $this->poster->post("users/{$userId}/tokens");
        return $this->userTokenFactory->createFromClientResponseData($clientResponse->getData());
    }
}
