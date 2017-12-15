<?php

namespace DCG\Cinema\Api\Cinema;

use DCG\Cinema\Model\Cinema;
use DCG\Cinema\Request\Client\GetterInterface;

class CinemasProvider
{
    private $getter;
    private $cinemaFactory;

    public function __construct(
        GetterInterface $getter,
        CinemaFactory $cinemaFactory
    ) {
        $this->getter = $getter;
        $this->cinemaFactory = $cinemaFactory;
    }

    /**
     * @param string $chainId
     * @return Cinema[]
     * @throws \Exception
     */
    public function getCinemas(string $chainId): array
    {
        $clientResponse = $this->getter->get("chains/{$chainId}/cinemas");

        $cinemas = [];
        foreach ($clientResponse->getData() as $entry) {
            $cinemas[] = $this->cinemaFactory->createFromClientResponseData($entry);
        }

        return $cinemas;
    }
}
