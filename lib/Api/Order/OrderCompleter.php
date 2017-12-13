<?php

namespace DCG\Cinema\Api\Order;

use DCG\Cinema\Request\Client\ClientInterface;
use DCG\Cinema\Model\OrderCompletionResponse;

class OrderCompleter
{
    private $client;
    private $orderCompletionResponseFactory;

    public function __construct(
        ClientInterface $client,
        OrderCompletionResponseFactory $orderCompletionResponseFactory
    ) {
        $this->client = $client;
        $this->orderCompletionResponseFactory = $orderCompletionResponseFactory;
    }

    /**
     * @param string $transactionId
     * @param array|null $data
     * @return OrderCompletionResponse
     * @throws \Exception
     */
    public function completeOrder($transactionId, $data = null)
    {
        $body = $data === null ? null : json_encode($data);
        $clientResponse = $this->client->patch("transactions/{$transactionId}", $body);
        return $this->orderCompletionResponseFactory->createFromClientResponseData($clientResponse->getData());
    }
}
