<?php

namespace DCG\Cinema\Request\Guzzle;

use DCG\Cinema\Model\UserToken;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\ClientInterface as GuzzleClientInterface;

class GuzzleClientFactory implements GuzzleClientFactoryInterface
{
    private $host;
    private $clientToken;

    /**
     * @param string $host the base URL of the target API.
     * @param string $clientToken
     */
    public function __construct(string $host, string $clientToken)
    {
        $this->host = $host;
        $this->clientToken = $clientToken;
    }

    /**
     * @param UserToken $userToken
     * @return GuzzleClientInterface
     */
    public function create(UserToken $userToken): GuzzleClientInterface
    {
        $headers = $this->getCommonHeaders();
        $headers['User-Token'] = $userToken->getToken();
        return $this->createWithHeaders($headers);
    }

    /**
     * @return GuzzleClientInterface
     */
    public function createUnauthenticated(): GuzzleClientInterface
    {
        return $this->createWithHeaders($this->getCommonHeaders());
    }

    private function createWithHeaders(array $headers): GuzzleClientInterface
    {
        // Ensure there's always a trailing slash to prevent Guzzle from ignoring any path component
        $baseUri = rtrim($this->host, '/') . '/';

        return new GuzzleClient([
            'base_uri' => $baseUri,
            'headers' => $headers,
            'http_errors' => false,
        ]);
    }

    private function getCommonHeaders(): array
    {
        return [
            'Client-Token' => $this->clientToken,
            'Content-Type' => 'application/json',
        ];
    }
}
