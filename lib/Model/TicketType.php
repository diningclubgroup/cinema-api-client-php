<?php

namespace DCG\Cinema\Model;

class TicketType
{
    private $id;
    private $vendorId;
    private $chainId;
    private $locationId;
    private $price;
    private $currency;
    private $conditionsOfUse;
    private $properties;
    private $hasLowQuantity;

    /**
     * @param string $id
     * @param string $vendorId
     * @param string $chainId
     * @param string $locationId
     * @param float $price
     * @param string $currency
     * @param string $conditionsOfUse
     * @param string[] $properties
     * @param bool $hasLowQuantity
     */
    public function __construct(
        $id,
        $vendorId,
        $chainId,
        $locationId,
        $price,
        $currency,
        $conditionsOfUse,
        $properties,
        $hasLowQuantity
    ) {
        $this->id = $id;
        $this->vendorId = $vendorId;
        $this->chainId = $chainId;
        $this->locationId = $locationId;
        $this->price = $price;
        $this->currency = $currency;
        $this->conditionsOfUse = $conditionsOfUse;
        $this->properties = $properties;
        $this->hasLowQuantity = $hasLowQuantity;
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
    public function getVendorId()
    {
        return $this->vendorId;
    }

    /**
     * @return string
     */
    public function getChainId()
    {
        return $this->chainId;
    }

    /**
     * @return string
     */
    public function getLocationId()
    {
        return $this->locationId;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @return string
     */
    public function getConditionsOfUse()
    {
        return $this->conditionsOfUse;
    }

    /**
     * @return string[]
     */
    public function getProperties()
    {
        return $this->properties;
    }

    /**
     * @return bool
     */
    public function getHasLowQuantity()
    {
        return $this->hasLowQuantity;
    }
}
