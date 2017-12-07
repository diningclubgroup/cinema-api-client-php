<?php

namespace DCG\Cinema\Api\User;

use DCG\Cinema\Exception\UnexpectedResponseContentException;
use DCG\Cinema\Validator\ClientResponseDataFieldValidator;
use DCG\Cinema\Model\User;

class UserFactory
{
    private $fieldValidator;

    public function __construct(ClientResponseDataFieldValidator $fieldValidator)
    {
        $this->fieldValidator = $fieldValidator;
    }

    /**
     * @param array $data
     * @return User
     * @throws UnexpectedResponseContentException
     */
    public function createFromClientResponseData($data)
    {
        if (!$this->fieldValidator->validate($data, array(
            'id',
            'firstname',
            'surname',
            'email',
        ))) {
            throw new UnexpectedResponseContentException();
        }

        return new User(
            $data['id'],
            $data['firstname'],
            $data['surname'],
            $data['email']
        );
    }
}
