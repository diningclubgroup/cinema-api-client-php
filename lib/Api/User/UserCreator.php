<?php

namespace DCG\Cinema\Api\User;

use DCG\Cinema\Model\User;
use DCG\Cinema\Request\Client\Poster;

class UserCreator
{
    private $poster;
    private $userFactory;

    public function __construct(
        Poster $poster,
        UserFactory $userFactory
    ) {
        $this->poster = $poster;
        $this->userFactory = $userFactory;
    }

    /**
     * @param array $data
     * @return User
     * @throws \Exception
     */
    public function createUser(array $data): User
    {
        $clientResponse = $this->poster->post('users', json_encode($data));
        return $this->userFactory->createFromClientResponseData($clientResponse->getData());
    }
}
