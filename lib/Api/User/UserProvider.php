<?php

namespace DCG\Cinema\Api\User;

use DCG\Cinema\Request\Client\ClientInterface;
use DCG\Cinema\Model\User;

class UserProvider
{
    private $client;
    private $userFactory;

    public function __construct(
        ClientInterface $client,
        UserFactory $userFactory
    ) {
        $this->client = $client;
        $this->userFactory = $userFactory;
    }

    /**
     * @param string $email
     * @return User
     * @throws \Exception
     */
    public function getUserByEmail(string $email): User
    {
        $clientResponse = $this->client->get('users', ['email' => $email]);

        if (!isset($clientResponse->getData()[0])) {
            throw new \RuntimeException('User not found');
        }

        return $this->userFactory->createFromClientResponseData($clientResponse->getData()[0]);
    }
}
