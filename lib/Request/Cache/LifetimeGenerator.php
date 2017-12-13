<?php

namespace DCG\Cinema\Request\Cache;

class LifetimeGenerator
{
    private $minLifetimeSeconds;
    private $maxLifetimeSeconds;

    public function __construct($minLifetimeSeconds, $maxLifetimeSeconds)
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
    public function generateLifetimeSeconds()
    {
        return mt_rand($this->minLifetimeSeconds, $this->maxLifetimeSeconds);
    }
}
