<?php

namespace DCG\Cinema\Request\Guzzle;

use DCG\Cinema\Model\UserToken;
use GuzzleHttp\ClientInterface as GuzzleClientInterface;

interface GuzzleClientFactoryInterface
{
    /**
     * @param UserToken $userToken
     * @return GuzzleClientInterface
     */
    public function create($userToken);

    /**
     * @return GuzzleClientInterface
     */
    public function createUnauthenticated();
}
