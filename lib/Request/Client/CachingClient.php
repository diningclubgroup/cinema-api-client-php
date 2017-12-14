<?php

namespace DCG\Cinema\Request\Client;

use DCG\Cinema\Cache\CacheInterface;
use DCG\Cinema\Request\Cache\KeyGenerator;
use DCG\Cinema\Request\Cache\LifetimeGenerator;
use DCG\Cinema\Request\ClientResponse;

class CachingClient implements ClientInterface
{
    const CACHE_PREFIX = 'cinema:request:';

    private $client;
    private $cache;
    private $keyGenerator;
    private $lifetimeGenerator;

    public function __construct(
        ClientInterface $client,
        CacheInterface $cache,
        KeyGenerator $keyGenerator,
        LifetimeGenerator $lifetimeGenerator
    ) {
        $this->client = $client;
        $this->cache = $cache;
        $this->keyGenerator = $keyGenerator;
        $this->lifetimeGenerator = $lifetimeGenerator;
    }

    /**
     * @inheritdoc
     */
    public function get(string $path, array $queryParams = [], array $successStatusCodes = [200]): ClientResponse
    {
        $cacheKey = $this->keyGenerator->generateKey('get', $path, $queryParams, $successStatusCodes);
        $result = $this->cache->get($cacheKey);

        if ($result === null) {
            $result = $this->client->get($path, $queryParams, $successStatusCodes);
            $this->cache->set($cacheKey, $result, $this->lifetimeGenerator->generateLifetimeSeconds());
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function post(string $path, string $body = null, array $successStatusCodes = [201]): ClientResponse
    {
        return $this->client->post($path, $body, $successStatusCodes);
    }

    /**
     * @inheritdoc
     */
    public function patch(string $path, string $body = null, array $successStatusCodes = [200]): ClientResponse
    {
        return $this->client->patch($path, $body, $successStatusCodes);
    }
}
