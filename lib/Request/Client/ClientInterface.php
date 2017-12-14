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
    public function get(string $path, array $queryParams = [], array $successStatusCodes = [200]): ClientResponse;

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
    public function post(string $path, string $body = null, array $successStatusCodes = [201]): ClientResponse;

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
    public function patch(string $path, string $body = null, array $successStatusCodes = [200]): ClientResponse;
}
