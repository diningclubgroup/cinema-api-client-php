<?php

namespace Api\Order;

use PHPUnit\Framework\TestCase;
use DCG\Cinema\Validator\ClientResponseDataFieldValidator;
use DCG\Cinema\Exception\UnexpectedResponseContentException;
use DCG\Cinema\Api\Order\OrderCompletionResponseFactory;

class OrderCompletionResponseFactoryTest extends TestCase
{

    public function testItReturnsAValidOrderCompletionResponse()
    {
        $validator = new ClientResponseDataFieldValidator();
        $SUT = new OrderCompletionResponseFactory($validator);
        $data = [
            'id' => "test_id",
            'status_code' => "test_status_code",
            'status_message' => "test_status_message",
            'is_successful' => "test_is_successful",
            'order_id' => "test_order_id"
        ];

        $result = $SUT->createFromClientResponseData($data);
        $this->assertEquals("test_id", $result->getId());
        $this->assertEquals("test_status_code", $result->getStatusCode());
        $this->assertEquals("test_status_message", $result->getStatusMessage());
        $this->assertEquals("test_is_successful", $result->getIsSuccessful());
        $this->assertEquals("test_order_id", $result->getOrderId());
    }

    public function testItThrowsExceptionOnInvalidInputs()
    {
        $validator = new ClientResponseDataFieldValidator();
        $SUT = new OrderCompletionResponseFactory($validator);
        $data = [];

        $this->expectException(UnexpectedResponseContentException::class);

        $SUT->createFromClientResponseData($data);
    }
}
