<?php

namespace DCG\Cinema\Api\Chain;

use DCG\Cinema\Model\Chain;
use DCG\Cinema\Request\Client\GetterInterface;

class ChainsProvider
{
    private $getter;
    private $chainFactory;

    public function __construct(
        GetterInterface $getter,
        ChainFactory $chainFactory
    ) {
        $this->getter = $getter;
        $this->chainFactory = $chainFactory;
    }

    /**
     * @return Chain[]
     * @throws \Exception
     */
    public function getChains(): array
    {
        $clientResponse = $this->getter->get('chains');

        $chains = [];
        foreach ($clientResponse->getData() as $entry) {
            $chains[] = $this->chainFactory->createFromClientResponseData($entry);
        }

        return $chains;
    }
}
