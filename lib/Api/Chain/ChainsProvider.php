<?php

namespace DCG\Cinema\Api\Chain;

use DCG\Cinema\Request\Client\ClientInterface;
use DCG\Cinema\Model\Chain;

class ChainsProvider
{
    private $client;
    private $chainFactory;

    public function __construct(
        ClientInterface $client,
        ChainFactory $chainFactory
    ) {
        $this->client = $client;
        $this->chainFactory = $chainFactory;
    }

    /**
     * @return Chain[]
     * @throws \Exception
     */
    public function getChains()
    {
        $clientResponse = $this->client->get('chains');

        $chains = [];
        foreach ($clientResponse->getData() as $entry) {
            $chains[] = $this->chainFactory->createFromClientResponseData($entry);
        }

        return $chains;
    }
}
