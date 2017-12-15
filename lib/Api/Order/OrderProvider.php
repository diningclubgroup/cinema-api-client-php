<?php

namespace DCG\Cinema\Api\Order;

use DCG\Cinema\Model\Order;
use DCG\Cinema\Request\Client\GetterInterface;

class OrderProvider
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
     * @param string $orderId
     * @return Order
     * @throws \Exception
     */
    public function getOrder(string $orderId): Order
    {
        $clientResponse = $this->getter->get("orders/{$orderId}");
        return $this->orderFactory->createFromClientResponseData($clientResponse->getData());
    }
}
