<?php

namespace DCG\Cinema\Api\Order;

use DCG\Cinema\Model\Order;
use DCG\Cinema\Request\Client\GetterInterface;

class OrdersProvider
{
    private $getter;
    private $orderFactory;

    public function __construct(
        GetterInterface $getter,
        OrderFactory $orderFactory
    ) {
        $this->getter = $getter;
        $this->orderFactory = $orderFactory;
    }

    /**
     * @param string $cinemaUuid
     * @return Order[]
     * @throws \Exception
     */
    public function getOrders(string $cinemaUuid): array
    {
        $clientResponse = $this->getter->get('orders', ['userId' => $cinemaUuid]);

        $orders = [];
        foreach ($clientResponse->getData() as $entry) {
            $orders[] = $this->orderFactory->createFromClientResponseData($entry);
        }

        return $orders;
    }
}
