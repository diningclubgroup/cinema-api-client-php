<?php

namespace DCG\Cinema\Model;

class Chain
{
    private $id;
    private $name;
    private $maxTickets;
    private $introductionInstructions;
    private $howToRedeem;

    /**
     * @param string $id
     * @param string $name
     * @param int $maxTickets
     * @param string $introductionInstructions
     * @param string $howToRedeem
     */
    public function __construct($id, $name, $maxTickets, $introductionInstructions, $howToRedeem)
    {
        $this->id = $id;
        $this->name = $name;
        $this->maxTickets = $maxTickets;
        $this->introductionInstructions = $introductionInstructions;
        $this->howToRedeem = $howToRedeem;
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
     * @return int
     */
    public function getMaxTickets()
    {
        return $this->maxTickets;
    }

    /**
     * @return string
     */
    public function getIntroductionInstructions()
    {
        return $this->introductionInstructions;
    }

    /**
     * @return string
     */
    public function getHowToRedeem()
    {
        return $this->howToRedeem;
    }
}
