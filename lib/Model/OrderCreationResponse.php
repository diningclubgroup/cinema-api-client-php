<?php

namespace DCG\Cinema\Model;

class OrderCreationResponse
{
    private $orderId;
    private $transactionId;
    private $redirectUrl;

    /**
     * @param string $orderId
     * @param string $transactionId
     * @param string $redirectUrl
     */
    public function __construct($orderId, $transactionId, $redirectUrl)
    {
        $this->orderId = $orderId;
        $this->transactionId = $transactionId;
        $this->redirectUrl = $redirectUrl;
    }

    /**
     * @return string
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @return string
     */
    public function getTransactionId()
    {
        return $this->transactionId;
    }

    /**
     * @return string
     */
    public function getRedirectUrl()
    {
        return $this->redirectUrl;
    }
}
