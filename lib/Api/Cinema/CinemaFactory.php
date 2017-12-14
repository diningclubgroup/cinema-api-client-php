<?php

namespace DCG\Cinema\Api\Cinema;

use DCG\Cinema\Exception\UnexpectedResponseContentException;
use DCG\Cinema\Validator\ClientResponseDataFieldValidator;
use DCG\Cinema\Model\Cinema;

class CinemaFactory
{
    private $fieldValidator;

    public function __construct(ClientResponseDataFieldValidator $fieldValidator)
    {
        $this->fieldValidator = $fieldValidator;
    }

    /**
     * @param array $data
     * @return Cinema
     * @throws UnexpectedResponseContentException
     */
    public function createFromClientResponseData(array $data): Cinema
    {
        if (!$this->fieldValidator->validate($data, array(
            'id',
            'name',
            'is_exempt',
            'location_id',
        ))) {
            throw new UnexpectedResponseContentException();
        }

        return new Cinema(
            $data['id'],
            $data['name'],
            $data['is_exempt'],
            $data['location_id']
        );
    }
}
