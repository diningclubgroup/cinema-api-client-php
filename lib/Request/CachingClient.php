<?php

namespace DCG\Cinema\Request;

use DCG\Cinema\Cache\CacheInterface;
use DCG\Cinema\Request\Cache\KeyGenerator;
use DCG\Cinema\Request\Cache\LifetimeGenerator;

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
    public function get($path, $queryParams = [], $successStatusCodes = [200])
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
    public function post($path, $body = null, $successStatusCodes = [201])
    {
        return $this->client->post($path, $body, $successStatusCodes);
    }

    /**
     * @inheritdoc
     */
    public function patch($path, $body = null, $successStatusCodes = [200])
    {
        return $this->client->patch($path, $body, $successStatusCodes);
    }

    /**
     * @inheritdoc
     */
    public function getUnauthenticated($path, $queryParams = [], $successStatusCodes = [200])
    {
        $cacheKey = $this->keyGenerator->generateKey('getUnauthenticated', $path, $queryParams, $successStatusCodes);
        $result = $this->cache->get($cacheKey);

        if ($result === null) {
            $result = $this->client->getUnauthenticated($path, $queryParams, $successStatusCodes);
            $this->cache->set($cacheKey, $result, $this->lifetimeGenerator->generateLifetimeSeconds());
        }

        return $result;
    }

    /**
     * @inheritdoc
     */
    public function postUnauthenticated($path, $body = null, $successStatusCodes = [201])
    {
        return $this->client->postUnauthenticated($path, $body, $successStatusCodes);
    }
}
