<?php

namespace DCG\Cinema\Api\TermsConditions;

use DCG\Cinema\Model\TermsConditions;
use DCG\Cinema\Request\Client\GetterInterface;

class TermsConditionsProvider
{
    private $getter;
    private $termsConditionsFactory;

    public function __construct(
        GetterInterface $getter,
        TermsConditionsFactory $termsConditionsFactory
    ) {
        $this->getter = $getter;
        $this->termsConditionsFactory = $termsConditionsFactory;
    }

    /**
     * @return TermsConditions
     * @throws \Exception
     */
    public function getTermsConditions(): TermsConditions
    {
        $clientResponse = $this->getter->get('terms-and-conditions');
        return $this->termsConditionsFactory->createFromClientResponseData($clientResponse->getData());
    }
}
