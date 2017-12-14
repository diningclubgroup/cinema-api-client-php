<?php

namespace DCG\Cinema\Api\Order;

use DCG\Cinema\Request\Client\ClientInterface;
use DCG\Cinema\Model\OrderCreationResponse;

class OrderCreator
{
    private $client;
    private $orderCreationResponseFactory;

    public function __construct(
        ClientInterface $client,
        OrderCreationResponseFactory $orderCreationResponseFactory
    ) {
        $this->client = $client;
        $this->orderCreationResponseFactory = $orderCreationResponseFactory;
    }

    /**
     * @param array $data
     * @return OrderCreationResponse
     * @throws \Exception
     */
    public function createOrder(array $data): OrderCreationResponse
    {
        $clientResponse = $this->client->post('orders', json_encode($data));
        return $this->orderCreationResponseFactory->createFromClientResponseData($clientResponse->getData());
    }
}
