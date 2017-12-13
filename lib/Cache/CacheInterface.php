<?php

namespace DCG\Cinema\Cache;

interface CacheInterface
{
    /**
     * Gets the value of the specified key from the cache.
     * Returns null if the key does not exist or has expired.
     *
     * @param string $key
     * @return mixed
     */
    public function get($key);

    /**
     * Sets the specified value in the cache using the specified key.
     *
     * @param string $key
     * @param mixed $value
     * @param int $lifetimeSeconds
     */
    public function set($key, $value, $lifetimeSeconds);
}
