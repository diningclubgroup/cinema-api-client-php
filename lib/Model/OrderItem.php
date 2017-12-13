<?php

namespace DCG\Cinema\Model;

class OrderItem
{
    private $id;
    private $ticketTypeId;
    private $quantity;
    private $price;
    private $bookingFee;
    private $redemptionCodes;

    /**
     * @param string $id
     * @param string $ticketTypeId
     * @param int $quantity
     * @param float $price
     * @param string $bookingFee
     * @param string[] $redemptionCodes
     */
    public function __construct(
        $id,
        $ticketTypeId,
        $quantity,
        $price,
        $bookingFee,
        $redemptionCodes
    ) {
        $this->id = $id;
        $this->ticketTypeId = $ticketTypeId;
        $this->quantity = $quantity;
        $this->price = $price;
        $this->bookingFee = $bookingFee;
        $this->redemptionCodes = $redemptionCodes;
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
    public function getTicketTypeId()
    {
        return $this->ticketTypeId;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return float
     */
    public function getBookingFee()
    {
        return $this->bookingFee;
    }

    /**
     * @return string[]
     */
    public function getRedemptionCodes()
    {
        return $this->redemptionCodes;
    }
}
