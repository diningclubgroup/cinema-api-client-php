<?php

namespace DCG\Cinema\Api\Order;

use DCG\Cinema\Model\OrderCompletionResponse;
use DCG\Cinema\Request\Client\Patcher;

class OrderCompleter
{
    private $patcher;
    private $orderCompletionResponseFactory;

    public function __construct(
        Patcher $patcher,
        OrderCompletionResponseFactory $orderCompletionResponseFactory
    ) {
        $this->patcher = $patcher;
        $this->orderCompletionResponseFactory = $orderCompletionResponseFactory;
    }

    /**
     * @param string $transactionId
     * @param array|null $data
     * @return OrderCompletionResponse
     * @throws \Exception
     */
    public function completeOrder(string $transactionId, array $data = null): OrderCompletionResponse
    {
        $body = $data === null ? null : json_encode($data);
        $clientResponse = $this->patcher->patch("transactions/{$transactionId}", $body);
        return $this->orderCompletionResponseFactory->createFromClientResponseData($clientResponse->getData());
    }
}
