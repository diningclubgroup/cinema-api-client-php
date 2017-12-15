<?php

namespace DCG\Cinema\Api\Order;

use DCG\Cinema\Model\OrderCreationResponse;
use DCG\Cinema\Request\Client\Poster;

class OrderCreator
{
    private $poster;
    private $orderCreationResponseFactory;

    public function __construct(
        Poster $poster,
        OrderCreationResponseFactory $orderCreationResponseFactory
    ) {
        $this->poster = $poster;
        $this->orderCreationResponseFactory = $orderCreationResponseFactory;
    }

    /**
     * @param array $data
     * @return OrderCreationResponse
     * @throws \Exception
     */
    public function createOrder(array $data): OrderCreationResponse
    {
        $clientResponse = $this->poster->post('orders', json_encode($data));
        return $this->orderCreationResponseFactory->createFromClientResponseData($clientResponse->getData());
    }
}
