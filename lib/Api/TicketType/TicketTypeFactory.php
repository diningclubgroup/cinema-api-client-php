<?php

namespace DCG\Cinema\Api\TicketType;

use DCG\Cinema\Exception\UnexpectedResponseContentException;
use DCG\Cinema\Validator\ClientResponseDataFieldValidator;
use DCG\Cinema\Model\TicketType;

class TicketTypeFactory
{
    private $fieldValidator;

    public function __construct(ClientResponseDataFieldValidator $fieldValidator)
    {
        $this->fieldValidator = $fieldValidator;
    }

    /**
     * @param array $data
     * @return TicketType
     * @throws UnexpectedResponseContentException
     */
    public function createFromClientResponseData(array $data)
    {
        if (!$this->fieldValidator->validate($data, array(
            'id',
            'vendor_id',
            'chain_id',
            'location_id',
            'price',
            'currency',
            'conditions_of_use',
            'properties',
            'has_low_quantity',
        ))) {
            throw new UnexpectedResponseContentException();
        }

        return new TicketType(
            $data['id'],
            $data['vendor_id'],
            $data['chain_id'],
            $data['location_id'],
            $data['price'],
            $data['currency'],
            $data['conditions_of_use'],
            $data['properties'],
            $data['has_low_quantity']
        );
    }
}
