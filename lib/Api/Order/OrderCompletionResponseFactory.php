<?php

namespace DCG\Cinema\Api\Order;

use DCG\Cinema\Exception\UnexpectedResponseContentException;
use DCG\Cinema\Validator\ClientResponseDataFieldValidator;
use DCG\Cinema\Model\OrderCompletionResponse;

class OrderCompletionResponseFactory
{
    private $fieldValidator;

    public function __construct(ClientResponseDataFieldValidator $fieldValidator)
    {
        $this->fieldValidator = $fieldValidator;
    }

    /**
     * @param array $data
     * @return OrderCompletionResponse
     * @throws UnexpectedResponseContentException
     */
    public function createFromClientResponseData(array $data)
    {
        if (!$this->fieldValidator->validate($data, array(
            'id',
            'status_code',
            'status_message',
            'is_successful',
            'order_id',
        ))) {
            throw new UnexpectedResponseContentException();
        }

        return new OrderCompletionResponse(
            $data['id'],
            $data['status_code'],
            $data['status_message'],
            $data['is_successful'],
            $data['order_id']
        );
    }
}
