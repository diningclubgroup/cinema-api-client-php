<?php

namespace DCG\Cinema\Tests\Functional\Mocks;

use DCG\Cinema\Cache\CacheInterface;

class MockCache implements CacheInterface
{
    private $items;

    public function __construct(array $items = [])
    {
        $this->items = $items;
    }

    /**
     * Gets the value of the specified key from the cache.
     * Returns null if the key does not exist or has expired.
     *
     * @param string $key
     * @return mixed
     */
    public function get(string $key)
    {
        if (array_key_exists($key, $this->items)) {
            return $this->items[$key];
        }
        return null;
    }

    /**
     * Sets the specified value in the cache using the specified key.
     *
     * @param string $key
     * @param mixed $value
     * @param int $lifetimeSeconds
     */
    public function set(string $key, $value, int $lifetimeSeconds): void
    {
        $this->items[$key] = $value;
    }
}
