<?php

namespace DCG\Cinema\Api\Order;

use DCG\Cinema\Exception\UnexpectedResponseContentException;
use DCG\Cinema\Validator\ClientResponseDataFieldValidator;
use DCG\Cinema\Model\OrderItem;

class OrderItemFactory
{
    private $fieldValidator;

    public function __construct(ClientResponseDataFieldValidator $fieldValidator)
    {
        $this->fieldValidator = $fieldValidator;
    }

    /**
     * @param array $data
     * @return OrderItem
     * @throws UnexpectedResponseContentException
     */
    public function createFromClientResponseData($data)
    {
        if (!$this->fieldValidator->validate($data, array(
            'id',
            'ticket_type_id',
            'quantity',
            'price',
            'booking_fee',
            'redemption_codes',
        ))) {
            throw new UnexpectedResponseContentException();
        }

        return new OrderItem(
            $data['id'],
            $data['ticket_type_id'],
            $data['quantity'],
            $data['price'],
            $data['booking_fee'],
            $data['redemption_codes']
        );
    }
}
