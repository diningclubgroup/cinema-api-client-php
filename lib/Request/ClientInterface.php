<?php

namespace DCG\Cinema\Request;

use DCG\Cinema\Exception\UnexpectedResponseContentException;
use DCG\Cinema\Exception\UnexpectedStatusCodeException;
use DCG\Cinema\Exception\UserNotAuthenticatedException;

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

    /**
     * @param string $path
     * @param array $queryParams
     * @param int[] $successStatusCodes
     * @return ClientResponse
     * @throws UnexpectedStatusCodeException
     * @throws UnexpectedResponseContentException
     * @throws \Exception
     */
    public function getUnauthenticated($path, $queryParams = [], $successStatusCodes = [200]);

    /**
     * @param string $path
     * @param string|null $body
     * @param int[] $successStatusCodes
     * @return ClientResponse
     * @throws UnexpectedStatusCodeException
     * @throws UnexpectedResponseContentException
     * @throws \Exception
     */
    public function postUnauthenticated($path, $body = null, $successStatusCodes = [201]);
}
