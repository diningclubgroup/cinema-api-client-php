<?php

namespace DCG\Cinema\ActiveUserToken;

use DCG\Cinema\Model\UserToken;
use DCG\Cinema\Session\SessionInterface;

class ActiveUserTokenProvider
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @return UserToken|null
     */
    public function getUserToken(): ?UserToken
    {
        $cinemaUserToken = $this->session->get(ActiveUserToken::SESSION_KEY_NAME);

        if ($cinemaUserToken !== null && !$cinemaUserToken->hasExpired()) {
            return $cinemaUserToken;
        }

        return null;
    }
}
