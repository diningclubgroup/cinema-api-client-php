<?php

namespace DCG\Cinema\Request\Client;

use DCG\Cinema\Exception\UnexpectedResponseContentException;
use DCG\Cinema\Exception\UnexpectedStatusCodeException;
use DCG\Cinema\Exception\UserNotAuthenticatedException;
use DCG\Cinema\Request\ClientResponse;

interface ClientInterface
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
    public function get($path, $queryParams = [], $successStatusCodes = [200]);

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
    public function post($path, $body = null, $successStatusCodes = [201]);

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
    public function patch($path, $body = null, $successStatusCodes = [200]);
}
