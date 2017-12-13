<?php

namespace DCG\Cinema\Api\TermsConditions;

use DCG\Cinema\Request\ClientInterface;
use DCG\Cinema\Model\TermsConditions;

class TermsConditionsProvider
{
    private $client;
    private $termsConditionsFactory;

    public function __construct(
        ClientInterface $client,
        TermsConditionsFactory $termsConditionsFactory
    ) {
        $this->client = $client;
        $this->termsConditionsFactory = $termsConditionsFactory;
    }

    /**
     * @return TermsConditions
     * @throws \Exception
     */
    public function getTermsConditions()
    {
        $clientResponse = $this->client->get('terms-and-conditions');
        return $this->termsConditionsFactory->createFromClientResponseData($clientResponse->getData());
    }
}
