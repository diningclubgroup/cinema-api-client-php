<?php

namespace DCG\Cinema\Api\Cinema;

use DCG\Cinema\Request\Client\ClientInterface;
use DCG\Cinema\Model\Cinema;

class CinemasProvider
{
    private $client;
    private $cinemaFactory;

    public function __construct(
        ClientInterface $client,
        CinemaFactory $cinemaFactory
    ) {
        $this->client = $client;
        $this->cinemaFactory = $cinemaFactory;
    }

    /**
     * @param int $chainId
     * @return Cinema[]
     * @throws \Exception
     */
    public function getCinemas($chainId)
    {
        $clientResponse = $this->client->get("chains/{$chainId}/cinemas");

        $cinemas = [];
        foreach ($clientResponse->getData() as $entry) {
            $cinemas[] = $this->cinemaFactory->createFromClientResponseData($entry);
        }

        return $cinemas;
    }
}
