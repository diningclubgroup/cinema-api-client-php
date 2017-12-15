<?php

namespace DCG\Cinema\Api\TicketType;

use DCG\Cinema\Model\TicketType;
use DCG\Cinema\Request\Client\GetterInterface;

class TicketTypesProvider
{
    private $getter;
    private $ticketTypeFactory;

    public function __construct(
        GetterInterface $getter,
        TicketTypeFactory $ticketTypeFactory
    ) {
        $this->getter = $getter;
        $this->ticketTypeFactory = $ticketTypeFactory;
    }

    /**
     * @param string $chainId
     * @return TicketType[]
     * @throws \Exception
     */
    public function getTicketTypes(string $chainId): array
    {
        $clientResponse = $this->getter->get("chains/{$chainId}/ticket-types");

        $ticketTypes = [];
        foreach ($clientResponse->getData() as $entry) {
            $ticketTypes[] = $this->ticketTypeFactory->createFromClientResponseData($entry);
        }

        return $ticketTypes;
    }
}
