<?php

namespace DCG\Cinema\Api\TicketType;

use DCG\Cinema\Request\Client\ClientInterface;
use DCG\Cinema\Model\TicketType;

class TicketTypesProvider
{
    private $client;
    private $ticketTypeFactory;

    public function __construct(
        ClientInterface $client,
        TicketTypeFactory $ticketTypeFactory
    ) {
        $this->client = $client;
        $this->ticketTypeFactory = $ticketTypeFactory;
    }

    /**
     * @param string $chainId
     * @return TicketType[]
     * @throws \Exception
     */
    public function getTicketTypes(string $chainId): array
    {
        $clientResponse = $this->client->get("chains/{$chainId}/ticket-types");

        $ticketTypes = [];
        foreach ($clientResponse->getData() as $entry) {
            $ticketTypes[] = $this->ticketTypeFactory->createFromClientResponseData($entry);
        }

        return $ticketTypes;
    }
}
