<?php

namespace DCG\Cinema\Api\UserToken;

use DCG\Cinema\Exception\UnexpectedResponseContentException;
use DCG\Cinema\Validator\ClientResponseDataFieldValidator;
use DCG\Cinema\Model\UserToken;

class UserTokenFactory
{
    private $fieldValidator;

    public function __construct(ClientResponseDataFieldValidator $fieldValidator)
    {
        $this->fieldValidator = $fieldValidator;
    }

    /**
     * @param array $data
     * @return UserToken
     * @throws UnexpectedResponseContentException
     */
    public function createFromClientResponseData(array $data)
    {
        if (!$this->fieldValidator->validate($data, array(
            'token',
            'expiration_date'
        ))) {
            throw new UnexpectedResponseContentException();
        }

        return new UserToken(
            $data['token'],
            strtotime($data['expiration_date'])
        );
    }
}
