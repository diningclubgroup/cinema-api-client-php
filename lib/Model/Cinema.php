<?php

namespace DCG\Cinema\Model;

class Cinema
{
    private $id;
    private $name;
    private $isExempt;
    private $locationId;

    /**
     * @param string $id
     * @param string $name
     * @param bool $isExempt
     * @param string $locationId
     */
    public function __construct($id, $name, $isExempt, $locationId)
    {
        $this->id = $id;
        $this->name = $name;
        $this->isExempt = $isExempt;
        $this->locationId = $locationId;
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return bool
     */
    public function getIsExempt()
    {
        return $this->isExempt;
    }

    /**
     * @return string
     */
    public function getLocationId()
    {
        return $this->locationId;
    }
}
