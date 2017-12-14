<?php

namespace DCG\Cinema\Api\User;

use DCG\Cinema\Request\Client\ClientInterface;
use DCG\Cinema\Model\User;

class UserCreator
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
     * @param array $data
     * @return User
     * @throws \Exception
     */
    public function createUser(array $data): User
    {
        $clientResponse = $this->client->post('users', json_encode($data));
        return $this->userFactory->createFromClientResponseData($clientResponse->getData());
    }
}
