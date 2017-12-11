<?php

namespace DCG\Cinema\Tests\Unit\Api\Order;

use PHPUnit\Framework\TestCase;
use DCG\Cinema\Validator\ClientResponseDataFieldValidator;
use DCG\Cinema\Api\Order\OrderCreationResponseFactory;
use DCG\Cinema\Exception\UnexpectedResponseContentException;

class OrderCreationResponseFactoryTest extends TestCase
{

    public function testItReturnsAValidOrderCreationResponse()
    {
        $validator = new ClientResponseDataFieldValidator();
        $SUT = new OrderCreationResponseFactory($validator);
        $data = [
            'order_id' => "test_order_id",
            'transaction_id' => "test_transaction_id",
            'redirect_url' => "test_redirect_url"
        ];

        $result = $SUT->createFromClientResponseData($data);
        $this->assertEquals("test_order_id", $result->getOrderId());
        $this->assertEquals("test_transaction_id", $result->getTransactionId());
        $this->assertEquals("test_redirect_url", $result->getRedirectUrl());
    }

    public function testItThrowsExceptionOnInvalidInputs()
    {
        $validator = new ClientResponseDataFieldValidator();
        $SUT = new OrderCreationResponseFactory($validator);
        $data = [];

        $this->expectException(UnexpectedResponseContentException::class);

        $SUT->createFromClientResponseData($data);
    }
}
