<?php

namespace DCG\Cinema\Tests\Unit\Api\Cinema;

use PHPUnit\Framework\TestCase;
use DCG\Cinema\Validator\ClientResponseDataFieldValidator;
use DCG\Cinema\Api\Cinema\CinemaFactory;
use DCG\Cinema\Exception\UnexpectedResponseContentException;

class CinemaFactoryTest extends TestCase
{

    public function testItReturnsAValidCinema()
    {
        $validator = new ClientResponseDataFieldValidator();
        $SUT = new CinemaFactory($validator);
        $data = [
            'id' => "test_id",
            'name' => "test_name",
            'is_exempt' => "test_is_exempt",
            'location_id' => "test_location_id"
        ];

        $result = $SUT->createFromClientResponseData($data);

        $this->assertEquals("test_id", $result->getId());
        $this->assertEquals("test_name", $result->getName());
        $this->assertEquals("test_is_exempt", $result->getIsExempt());
        $this->assertEquals("test_location_id", $result->getLocationId());
    }

    public function testItThrowsExceptionOnInvalidInputs()
    {
        $validator = new ClientResponseDataFieldValidator();
        $SUT = new CinemaFactory($validator);
        $data = [];

        $this->expectException(UnexpectedResponseContentException::class);

        $SUT->createFromClientResponseData($data);
    }
}
