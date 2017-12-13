<?php

namespace DCG\Cinema\Model;

class Order
{
    private $id;
    private $reference;
    private $userId;
    private $currency;
    private $isSuccessful;
    private $completedAt;
    private $items;

    /**
     * @param string $id
     * @param string $reference
     * @param string $userId
     * @param string $currency
     * @param bool $isSuccessful
     * @param string $completedAt
     * @param OrderItem[] $items
     */
    public function __construct(
        $id,
        $reference,
        $userId,
        $currency,
        $isSuccessful,
        $completedAt,
        $items
    ) {
        $this->id = $id;
        $this->reference = $reference;
        $this->userId = $userId;
        $this->currency = $currency;
        $this->isSuccessful = $isSuccessful;
        $this->completedAt = $completedAt;
        $this->items = $items;
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
    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @return string
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
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
    public function getCompletedAt()
    {
        return $this->completedAt;
    }

    /**
     * @return OrderItem[]
     */
    public function getItems()
    {
        return $this->items;
    }
}
