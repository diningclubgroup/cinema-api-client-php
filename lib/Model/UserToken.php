<?php

namespace DCG\Cinema\Model;

class UserToken
{
    private $token;
    private $expirationUnixTime;

    /**
     * @param string $token
     * @param int $expirationUnixTime
     */
    public function __construct(
        $token,
        $expirationUnixTime
    ) {
        $this->token = $token;
        $this->expirationUnixTime = $expirationUnixTime;
    }

    /**
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * @return int
     */
    public function getExpirationUnixTime()
    {
        return $this->expirationUnixTime;
    }

    /**
     * @return bool
     */
    public function hasExpired()
    {
        return $this->expirationUnixTime < time();
    }
}
