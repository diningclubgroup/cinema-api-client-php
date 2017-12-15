<?php

namespace DCG\Cinema\Request\Client;

use DCG\Cinema\Exception\UnexpectedResponseContentException;
use DCG\Cinema\Exception\UnexpectedStatusCodeException;
use DCG\Cinema\Exception\UserNotAuthenticatedException;
use DCG\Cinema\Request\ClientResponse;

interface GetterInterface
{
    /**
     * @param string $path
     * @param array $queryParams
     * @param int[] $successStatusCodes
     * @return ClientResponse
     * @throws UserNotAuthenticatedException
     * @throws UnexpectedStatusCodeException
     * @throws UnexpectedResponseContentException
     * @throws \Exception
     */
    public function get(string $path, array $queryParams = [], array $successStatusCodes = [200]): ClientResponse;
}
