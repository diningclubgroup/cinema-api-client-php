<?php

namespace DCG\Cinema\Session;

interface SessionInterface
{
    /**
     * Gets the value of the specified key from the session.
     * Returns null if the key does not exist.
     *
     * @param string $key
     * @return mixed
     */
    public function get($key);

    /**
     * Sets the specified value in the session using the specified key.
     *
     * @param string $key
     * @param mixed $value
     */
    public function set($key, $value);
}
