<?php

namespace DCG\Cinema\Model;

class OrderCompletionResponse
{
    private $id;
    private $statusCode;
    private $statusMessage;
    private $isSuccessful;
    private $orderId;

    /**
     * @param string $id
     * @param string $statusCode
     * @param string $statusMessage
     * @param bool $isSuccessful
     * @param string $orderId
     */
    public function __construct(
        $id,
        $statusCode,
        $statusMessage,
        $isSuccessful,
        $orderId
    ) {
        $this->id = $id;
        $this->statusCode = $statusCode;
        $this->statusMessage = $statusMessage;
        $this->isSuccessful = $isSuccessful;
        $this->orderId = $orderId;
    }

    /**
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }

    /**
     * @return string
     */
    public function getStatusMessage()
    {
        return $this->statusMessage;
    }

    /**
     * @return bool
     */
    public function getIsSuccessful()
    {
        return $this->isSuccessful;
    }

    /**
     * @return string
     */
    public function getOrderId()
    {
        return $this->orderId;
    }
}
