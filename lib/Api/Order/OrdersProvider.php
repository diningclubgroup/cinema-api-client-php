<?php

namespace DCG\Cinema\Api\Order;

use DCG\Cinema\Request\ClientInterface;
use DCG\Cinema\Model\Order;

class OrdersProvider
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
     * @param string $cinemaUuid
     * @return Order[]
     * @throws \Exception
     */
    public function getOrders($cinemaUuid)
    {
        $clientResponse = $this->client->get('orders', ['userId' => $cinemaUuid]);

        $orders = [];
        foreach ($clientResponse->getData() as $entry) {
            $orders[] = $this->orderFactory->createFromClientResponseData($entry);
        }

        return $orders;
    }
}
