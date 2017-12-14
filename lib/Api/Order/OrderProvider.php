<?php

namespace DCG\Cinema\Api\Order;

use DCG\Cinema\Request\Client\ClientInterface;
use DCG\Cinema\Model\Order;

class OrderProvider
{
    private $client;
    private $orderFactory;

    public function __construct(
        ClientInterface $client,
        OrderFactory $orderFactory
    ) {
        $this->client = $client;
        $this->orderFactory = $orderFactory;
    }

    /**
     * @param string $orderId
     * @return Order
     * @throws \Exception
     */
    public function getOrder(string $orderId): Order
    {
        $clientResponse = $this->client->get("orders/{$orderId}");
        return $this->orderFactory->createFromClientResponseData($clientResponse->getData());
    }
}
