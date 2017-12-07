<?php

namespace DCG\Cinema\Request;

use DCG\Cinema\ActiveUserToken\ActiveUserTokenProvider;
use DCG\Cinema\Exception\UnexpectedResponseContentException;
use DCG\Cinema\Exception\UnexpectedStatusCodeException;
use DCG\Cinema\Exception\UserNotAuthenticatedException;
use GuzzleHttp\ClientInterface as GuzzleClientInterface;

class Client implements ClientInterface
{
    private $guzzleClientFactory;
    private $activeUserTokenProvider;

    public function __construct(
        GuzzleClientFactory $guzzleClientFactory,
        ActiveUserTokenProvider $activeUserTokenProvider
    ) {
        $this->guzzleClientFactory = $guzzleClientFactory;
        $this->activeUserTokenProvider = $activeUserTokenProvider;
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
        return $this->processRequest($guzzleClient, 'GET', $path, $queryParams, null, $successStatusCodes);
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
        return $this->processRequest($guzzleClient, 'POST', $path, [], $body, $successStatusCodes);
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
        return $this->processRequest($guzzleClient, 'PATCH', $path, [], $body, $successStatusCodes);
    }

    /**
     * @inheritdoc
     */
    public function getUnauthenticated($path, $queryParams = [], $successStatusCodes = [200])
    {
        $guzzleClient = $this->guzzleClientFactory->createUnauthenticated();
        return $this->processRequest($guzzleClient, 'GET', $path, $queryParams, null, $successStatusCodes);
    }

    /**
     * @inheritdoc
     */
    public function postUnauthenticated($path, $body = null, $successStatusCodes = [201])
    {
        $guzzleClient = $this->guzzleClientFactory->createUnauthenticated();
        return $this->processRequest($guzzleClient, 'POST', $path, [], $body, $successStatusCodes);
    }

    /**
     * @param GuzzleClientInterface $guzzleClient
     * @param string $type
     * @param string $path
     * @param array $queryParams
     * @param string|null $body
     * @param int[] $successStatusCodes
     * @return ClientResponse
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    private function processRequest($guzzleClient, $type, $path, $queryParams, $body, $successStatusCodes)
    {
        $options = [];
        if ($body !== null) {
            $options['body'] = $body;
        }

        $queryString = '';
        if ($queryParams) {
            $queryString .= '?' . http_build_query($queryParams);
        }

        $response = $guzzleClient->request($type, $path . $queryString, $options);

        if (!in_array($response->getStatusCode(), $successStatusCodes)) {
            throw new UnexpectedStatusCodeException($response->getStatusCode());
        }

        $content = json_decode((string) $response->getBody(), true);

        return new ClientResponse(
            isset($content['meta']) ? $content['meta'] : [],
            isset($content['data']) ? $content['data'] : []
        );
    }
}
