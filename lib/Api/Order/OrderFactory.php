<?php

namespace DCG\Cinema\Api\Order;

use DCG\Cinema\Exception\UnexpectedResponseContentException;
use DCG\Cinema\Validator\ClientResponseDataFieldValidator;
use DCG\Cinema\Model\Order;

class OrderFactory
{
    private $fieldValidator;
    private $orderItemFactory;

    public function __construct(
        ClientResponseDataFieldValidator $fieldValidator,
        OrderItemFactory $orderItemFactory
    ) {
        $this->fieldValidator = $fieldValidator;
        $this->orderItemFactory = $orderItemFactory;
    }

    /**
     * @param array $data
     * @return Order
     * @throws UnexpectedResponseContentException
     */
    public function createFromClientResponseData($data)
    {
        if (!$this->fieldValidator->validate($data, array(
            'id',
            'reference',
            'user_id',
            'currency',
            'is_successful',
            'completed_at',
            'items',
        ))) {
            throw new UnexpectedResponseContentException();
        }

        $orderItems = [];
        foreach ($data['items'] as $item) {
            $orderItems[] = $this->orderItemFactory->createFromClientResponseData($item);
        }

        return new Order(
            $data['id'],
            $data['reference'],
            $data['user_id'],
            $data['currency'],
            $data['is_successful'],
            $data['completed_at'],
            $orderItems
        );
    }
}
