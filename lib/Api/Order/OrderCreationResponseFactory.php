<?php

namespace DCG\Cinema\Api\Order;

use DCG\Cinema\Exception\UnexpectedResponseContentException;
use DCG\Cinema\Validator\ClientResponseDataFieldValidator;
use DCG\Cinema\Model\OrderCreationResponse;

class OrderCreationResponseFactory
{
    private $fieldValidator;

    public function __construct(ClientResponseDataFieldValidator $fieldValidator)
    {
        $this->fieldValidator = $fieldValidator;
    }

    /**
     * @param array $data
     * @return OrderCreationResponse
     * @throws UnexpectedResponseContentException
     */
    public function createFromClientResponseData(array $data): OrderCreationResponse
    {
        if (!$this->fieldValidator->validate($data, array(
            'order_id',
            'transaction_id',
            'redirect_url',
        ))) {
            throw new UnexpectedResponseContentException();
        }

        return new OrderCreationResponse(
            $data['order_id'],
            $data['transaction_id'],
            $data['redirect_url']
        );
    }
}
