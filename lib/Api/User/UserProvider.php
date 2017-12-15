<?php

namespace DCG\Cinema\Api\User;

use DCG\Cinema\Model\User;
use DCG\Cinema\Request\Client\GetterInterface;

class UserProvider
{
    private $getter;
    private $userFactory;

    public function __construct(
        GetterInterface $getter,
        UserFactory $userFactory
    ) {
        $this->getter = $getter;
        $this->userFactory = $userFactory;
    }

    /**
     * @param string $email
     * @return User
     * @throws \Exception
     */
    public function getUserByEmail(string $email): User
    {
        $clientResponse = $this->getter->get('users', ['email' => $email]);

        if (!isset($clientResponse->getData()[0])) {
            throw new \RuntimeException('User not found');
        }

        return $this->userFactory->createFromClientResponseData($clientResponse->getData()[0]);
    }
}
