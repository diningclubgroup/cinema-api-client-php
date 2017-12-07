<?php

namespace DCG\Cinema\Api\Chain;

use DCG\Cinema\Exception\UnexpectedResponseContentException;
use DCG\Cinema\Validator\ClientResponseDataFieldValidator;
use DCG\Cinema\Model\Chain;

class ChainFactory
{
    private $fieldValidator;

    public function __construct(ClientResponseDataFieldValidator $fieldValidator)
    {
        $this->fieldValidator = $fieldValidator;
    }

    /**
     * @param array $data
     * @return Chain
     * @throws UnexpectedResponseContentException
     */
    public function createFromClientResponseData($data)
    {
        if (!$this->fieldValidator->validate($data, array(
            'id',
            'name',
            'maximum_number_of_tickets',
            'introduction_instructions',
            'how_to_redeem',
        ))) {
            throw new UnexpectedResponseContentException();
        }

        return new Chain(
            $data['id'],
            $data['name'],
            $data['maximum_number_of_tickets'],
            $data['introduction_instructions'],
            $data['how_to_redeem']
        );
    }
}
