<?php

namespace DCG\Cinema\Request\Guzzle;

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

    public function create(array $headers = []): GuzzleClientInterface
    {
        $headers = [
            'Client-Token' => $this->clientToken,
            'Content-Type' => 'application/json',
        ] + $headers;

        // Ensure there's always a trailing slash to prevent Guzzle from ignoring any path component
        $baseUri = rtrim($this->host, '/') . '/';

        return new GuzzleClient([
            'base_uri' => $baseUri,
            'headers' => $headers,
            'http_errors' => false,
        ]);
    }
}
