<?php

namespace DCG\Cinema\Tests\Unit\Api\Order;

use PHPUnit\Framework\TestCase;
use DCG\Cinema\Validator\ClientResponseDataFieldValidator;
use DCG\Cinema\Api\Order\OrderFactory;
use DCG\Cinema\Api\Order\OrderItemFactory;
use DCG\Cinema\Exception\UnexpectedResponseContentException;

class OrderFactoryTest extends TestCase
{

    public function testItReturnsAValidCinema()
    {
        $validator = new ClientResponseDataFieldValidator();
        $itemFactory = new OrderItemFactory($validator);
        $SUT = new OrderFactory($validator, $itemFactory);
        $data = [
            'id' => "test_id",
            'reference' => "test_reference",
            'user_id' => "test_user_id",
            'currency' => "test_currency",
            'is_successful' => "test_is_successful",
            'completed_at' => "test_completed_at",
            'items' => [
                [
                    'id' => "test_id",
                    'ticket_type_id' => "test_ticket_type_id",
                    'quantity' => "test_quantity",
                    'price' => "test_price",
                    'booking_fee' => "test_booking_fee",
                    'redemption_codes' => ["test_redemption_codes"]
                ]
            ],
        ];

        $result = $SUT->createFromClientResponseData($data);

        $this->assertEquals("test_id", $result->getId());
        $this->assertEquals("test_reference", $result->getReference());
        $this->assertEquals("test_user_id", $result->getUserId());
        $this->assertEquals("test_currency", $result->getCurrency());
        $this->assertEquals("test_is_successful", $result->getIsSuccessful());
        $this->assertEquals("test_completed_at", $result->getCompletedAt());

        $orderItem = $result->getItems()[0];
        $this->assertEquals("test_id", $orderItem->getId());
        $this->assertEquals("test_ticket_type_id", $orderItem->getTicketTypeId());
        $this->assertEquals("test_quantity", $orderItem->getQuantity());
        $this->assertEquals("test_price", $orderItem->getPrice());
        $this->assertEquals("test_booking_fee", $orderItem->getBookingFee());
        $this->assertEquals(["test_redemption_codes"], $orderItem->getRedemptionCodes());
    }
}
