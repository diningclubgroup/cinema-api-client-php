<?php

namespace DCG\Cinema\Request\Client;

use DCG\Cinema\Cache\CacheInterface;
use DCG\Cinema\Exception\UnexpectedResponseContentException;
use DCG\Cinema\Exception\UnexpectedStatusCodeException;
use DCG\Cinema\Exception\UserNotAuthenticatedException;
use DCG\Cinema\Request\Cache\KeyGenerator;
use DCG\Cinema\Request\Cache\LifetimeGenerator;
use DCG\Cinema\Request\ClientResponse;

class CachingGetter implements GetterInterface
{
    const CACHE_PREFIX = 'cinema:request:';

    private $getter;
    private $cache;
    private $keyGenerator;
    private $lifetimeGenerator;

    public function __construct(
        GetterInterface $getter,
        CacheInterface $cache,
        KeyGenerator $keyGenerator,
        LifetimeGenerator $lifetimeGenerator
    ) {
        $this->getter = $getter;
        $this->cache = $cache;
        $this->keyGenerator = $keyGenerator;
        $this->lifetimeGenerator = $lifetimeGenerator;
    }

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
    public function get(string $path, array $queryParams = [], array $successStatusCodes = [200]): ClientResponse
    {
        $cacheKey = $this->keyGenerator->generateKey('get', $path, $queryParams, $successStatusCodes);
        $result = $this->cache->get($cacheKey);

        if ($result === null) {
            $result = $this->getter->get($path, $queryParams, $successStatusCodes);
            $this->cache->set($cacheKey, $result, $this->lifetimeGenerator->generateLifetimeSeconds());
        }

        return $result;
    }
}
