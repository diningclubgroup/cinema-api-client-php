<?php

namespace DCG\Cinema\Request\Guzzle;

use DCG\Cinema\Model\UserToken;
use GuzzleHttp\ClientInterface as GuzzleClientInterface;

interface GuzzleClientFactoryInterface
{
    /**
     * @param array $headers
     * @return GuzzleClientInterface
     */
    public function create(array $headers = []): GuzzleClientInterface;
}
