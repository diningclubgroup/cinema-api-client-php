<?php

namespace DCG\Cinema\Tests\Unit\Api\Chain;

use PHPUnit\Framework\TestCase;
use DCG\Cinema\Validator\ClientResponseDataFieldValidator;
use DCG\Cinema\Api\Chain\ChainFactory;
use DCG\Cinema\Exception\UnexpectedResponseContentException;

class ChainFactoryTest extends TestCase
{

    public function testItReturnsAValidChain()
    {
        $validator = new ClientResponseDataFieldValidator();
        $SUT = new ChainFactory($validator);
        $data = [
            'id' => "test_id",
            'name' => "test_name",
            'maximum_number_of_tickets' => "test_maximum_number_of_tickets",
            'introduction_instructions' => "test_introduction_instructions",
            'how_to_redeem' => "test_how_to_redeem"
        ];

        $result = $SUT->createFromClientResponseData($data);

        $this->assertEquals("test_id", $result->getId());
        $this->assertEquals("test_name", $result->getName());
        $this->assertEquals("test_maximum_number_of_tickets", $result->getMaxTickets());
        $this->assertEquals("test_maximum_number_of_tickets", $result->getMaxTickets());
        $this->assertEquals("test_introduction_instructions", $result->getIntroductionInstructions());
        $this->assertEquals("test_how_to_redeem", $result->getHowToRedeem());
    }

    public function testItThrowsExceptionOnInvalidInputs()
    {
        $validator = new ClientResponseDataFieldValidator();
        $SUT = new ChainFactory($validator);
        $data = [];

        $this->expectException(UnexpectedResponseContentException::class);
        $SUT->createFromClientResponseData($data);
    }
}
