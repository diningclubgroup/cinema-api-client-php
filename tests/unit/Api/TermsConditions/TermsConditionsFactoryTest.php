<?php

namespace Api\TermsConditions;

use PHPUnit\Framework\TestCase;
use DCG\Cinema\Validator\ClientResponseDataFieldValidator;
use DCG\Cinema\Api\TermsConditions\TermsConditionsFactory;
use DCG\Cinema\Exception\UnexpectedResponseContentException;

class TermsConditionsFactoryTest extends TestCase
{

    public function testItReturnsValidTermsConditions()
    {
        $validator = new ClientResponseDataFieldValidator();
        $SUT = new TermsConditionsFactory($validator);
        $data = [
            'content' => "content"
        ];

        $result = $SUT->createFromClientResponseData($data);

        $this->assertEquals("content", $result->getContent());
    }

    public function testItThrowsExceptionOnInvalidInputs()
    {
        $validator = new ClientResponseDataFieldValidator();
        $SUT = new TermsConditionsFactory($validator);
        $data = [];

        $this->expectException(UnexpectedResponseContentException::class);
        $result = $SUT->createFromClientResponseData($data);
    }
}
