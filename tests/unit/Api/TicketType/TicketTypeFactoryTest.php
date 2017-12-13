<?php

namespace DCG\Cinema\Tests\Unit\Api\TicketType;

use PHPUnit\Framework\TestCase;
use DCG\Cinema\Validator\ClientResponseDataFieldValidator;
use DCG\Cinema\Api\TicketType\TicketTypeFactory;
use DCG\Cinema\Exception\UnexpectedResponseContentException;

class TicketTypeFactoryTest extends TestCase
{

    public function testItReturnsAValidTicketType()
    {
        $validator = new ClientResponseDataFieldValidator();
        $SUT = new TicketTypeFactory($validator);
        $data = [
            'id' => "test_id",
            'vendor_id' => "test_vendor_id",
            'chain_id' => "test_chain_id",
            'location_id' => "test_location_id",
            'price' => "test_price",
            'currency' => "test_currency",
            'conditions_of_use' => "test_conditions_of_use",
            'properties' => "test_properties",
            'has_low_quantity' => "test_has_low_quantity"
        ];

        $result = $SUT->createFromClientResponseData($data);

        $this->assertEquals("test_id", $result->getId());
        $this->assertEquals("test_vendor_id", $result->getVendorId());
        $this->assertEquals("test_chain_id", $result->getChainId());
        $this->assertEquals("test_location_id", $result->getLocationId());
        $this->assertEquals("test_price", $result->getPrice());
        $this->assertEquals("test_currency", $result->getCurrency());
        $this->assertEquals("test_conditions_of_use", $result->getConditionsOfUse());
        $this->assertEquals("test_properties", $result->getProperties());
        $this->assertEquals("test_has_low_quantity", $result->getHasLowQuantity());
    }

    public function testItThrowsExceptionOnInvalidInputs()
    {
        $validator = new ClientResponseDataFieldValidator();
        $SUT = new TicketTypeFactory($validator);
        $data = [];

        $this->expectException(UnexpectedResponseContentException::class);

        $SUT->createFromClientResponseData($data);
    }
}
