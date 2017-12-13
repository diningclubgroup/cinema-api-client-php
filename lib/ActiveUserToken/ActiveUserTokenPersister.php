<?php

namespace DCG\Cinema\ActiveUserToken;

use DCG\Cinema\Model\UserToken;
use DCG\Cinema\Session\SessionInterface;

class ActiveUserTokenPersister
{
    private $session;

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    /**
     * @param UserToken $userToken
     */
    public function persistUserToken(UserToken $userToken)
    {
        $this->session->set(ActiveUserToken::SESSION_KEY_NAME, $userToken);
    }
}
