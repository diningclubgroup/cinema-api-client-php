<?php

namespace DCG\Cinema\Request\Cache;

class LifetimeGenerator
{
    private $minLifetimeSeconds;
    private $maxLifetimeSeconds;

    /**
     * @param int $minLifetimeSeconds
     * @param int $maxLifetimeSeconds
     * @throws \RuntimeException
     */
    public function __construct(int $minLifetimeSeconds, int $maxLifetimeSeconds)
    {
        if ($minLifetimeSeconds > $maxLifetimeSeconds) {
            throw new \RuntimeException('Invalid cache lifetime configuration');
        }

        $this->minLifetimeSeconds = $minLifetimeSeconds;
        $this->maxLifetimeSeconds = $maxLifetimeSeconds;
    }

    /**
     * Generates a random lifetime between the specified min and max to avoid all cache expiring at the same time.
     *
     * @return int number of seconds between the min and max lifetime inclusive.
     */
    public function generateLifetimeSeconds(): int
    {
        return mt_rand($this->minLifetimeSeconds, $this->maxLifetimeSeconds);
    }
}
