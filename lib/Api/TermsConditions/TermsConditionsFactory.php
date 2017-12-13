<?php

namespace DCG\Cinema\Api\TermsConditions;

use DCG\Cinema\Exception\UnexpectedResponseContentException;
use DCG\Cinema\Validator\ClientResponseDataFieldValidator;
use DCG\Cinema\Model\TermsConditions;

class TermsConditionsFactory
{
    private $fieldValidator;

    public function __construct(ClientResponseDataFieldValidator $fieldValidator)
    {
        $this->fieldValidator = $fieldValidator;
    }

    /**
     * @param array $data
     * @return TermsConditions
     * @throws UnexpectedResponseContentException
     */
    public function createFromClientResponseData(array $data)
    {
        if (!$this->fieldValidator->validate($data, array('content'))) {
            throw new UnexpectedResponseContentException();
        }

        return new TermsConditions($data['content']);
    }
}
