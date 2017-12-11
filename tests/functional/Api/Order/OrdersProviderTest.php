<?php

namespace Tests\Functional\Api\Order;

use DCG\Cinema\Exception\UnexpectedResponseContentException;
use DCG\Cinema\Exception\UnexpectedStatusCodeException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Tests\Functional\Mocks\MockGuzzleClientDi;
use Tests\Functional\Mocks\MockGuzzleClientFactory;
use Tests\Functional\Mocks\MockSession;

class OrdersProviderTest extends TestCase
{
    public function testItReturnsTheExpectedOrders()
    {
        $mockGuzzleClientFactory = new MockGuzzleClientFactory(
            new MockHandler([
                new Response(200, [], json_encode([
                    'data' => [
                        [
                            'id' => 'idValue0',
                            'reference' => 'referenceValue0',
                            'user_id' => 'userIdValue0',
                            'currency' => 'currencyValue0',
                            'is_successful' => true,
                            'completed_at' => 'completedAtValue0',
                            'items' => [
                                [
                                    'id' => 'itemIdValue00',
                                    'ticket_type_id' => 'itemTicketTypeValue00',
                                    'quantity' => 1,
                                    'price' => 1.1,
                                    'booking_fee' => 0.1,
                                    'redemption_codes' => [
                                        'itemRedemptionCode000',
                                        'itemRedemptionCode001',
                                    ],
                                ],
                                [
                                    'id' => 'itemIdValue01',
                                    'ticket_type_id' => 'itemTicketTypeValue01',
                                    'quantity' => 2,
                                    'price' => 2.2,
                                    'booking_fee' => 0.2,
                                    'redemption_codes' => [
                                        'itemRedemptionCode010',
                                    ],
                                ],
                            ],
                        ],
                        [
                            'id' => 'idValue1',
                            'reference' => 'referenceValue1',
                            'user_id' => 'userIdValue1',
                            'currency' => 'currencyValue1',
                            'is_successful' => false,
                            'completed_at' => 'completedAtValue1',
                            'items' => [],
                        ],
                    ],
                ]))
            ])
        );

        $di = MockGuzzleClientDi::buildMockDi(MockSession::createWithActiveUserToken(), $mockGuzzleClientFactory);

        $orders = $di->getOrdersProvider()->getOrders('cinemaUuidValue');

        $this->assertCount(2, $orders);

        $order = $orders[0];
        $this->assertEquals('idValue0', $order->getId());
        $this->assertEquals('referenceValue0', $order->getReference());
        $this->assertEquals('userIdValue0', $order->getUserId());
        $this->assertEquals('currencyValue0', $order->getCurrency());
        $this->assertEquals(true, $order->getIsSuccessful());
        $this->assertEquals('completedAtValue0', $order->getCompletedAt());

        $this->assertCount(2, $order->getItems());

        $item = $order->getItems()[0];
        $this->assertEquals('itemIdValue00', $item->getId());
        $this->assertEquals('itemTicketTypeValue00', $item->getTicketTypeId());
        $this->assertEquals(1, $item->getQuantity());
        $this->assertEquals(1.1, $item->getPrice());
        $this->assertEquals(0.1, $item->getBookingFee());
        $this->assertEquals(['itemRedemptionCode000', 'itemRedemptionCode001'], $item->getRedemptionCodes());

        $item = $order->getItems()[1];
        $this->assertEquals('itemIdValue01', $item->getId());
        $this->assertEquals('itemTicketTypeValue01', $item->getTicketTypeId());
        $this->assertEquals(2, $item->getQuantity());
        $this->assertEquals(2.2, $item->getPrice());
        $this->assertEquals(0.2, $item->getBookingFee());
        $this->assertEquals(['itemRedemptionCode010'], $item->getRedemptionCodes());

        $order = $orders[1];
        $this->assertEquals('idValue1', $order->getId());
        $this->assertEquals('referenceValue1', $order->getReference());
        $this->assertEquals('userIdValue1', $order->getUserId());
        $this->assertEquals('currencyValue1', $order->getCurrency());
        $this->assertEquals(false, $order->getIsSuccessful());
        $this->assertEquals('completedAtValue1', $order->getCompletedAt());

        $this->assertCount(0, $order->getItems());

        $requestHistory = $mockGuzzleClientFactory->getHistory();
        $this->assertCount(1, $requestHistory);
        $this->assertEquals('GET', $requestHistory[0]['request']->getMethod());
        $this->assertEquals('orders?userId=cinemaUuidValue', (string)$requestHistory[0]['request']->getUri());
    }

    public function testItThrowsOnUnexpectedStatusCode()
    {
        $di = MockGuzzleClientDi::buildMockDi(
            MockSession::createWithActiveUserToken(),
            new MockGuzzleClientFactory(new MockHandler([new Response(201)]))
        );

        $this->expectException(UnexpectedStatusCodeException::class);

        $di->getOrdersProvider()->getOrders('cinemaUuid');
    }

    public function testItThrowsOnUnexpectedResponseContent()
    {
        $di = MockGuzzleClientDi::buildMockDi(
            MockSession::createWithActiveUserToken(),
            new MockGuzzleClientFactory(
                new MockHandler([
                    new Response(200, [], json_encode([
                        'data' => [
                            [
                                'id' => 'idValue0',
                            ],
                        ],
                    ]))
                ])
            )
        );

        $this->expectException(UnexpectedResponseContentException::class);

        $di->getOrdersProvider()->getOrders('cinemaUuid');
    }

    public function testItThrowsOnUnexpectedItemContent()
    {
        $mockGuzzleClientFactory = new MockGuzzleClientFactory(
            new MockHandler([
                new Response(200, [], json_encode([
                    'data' => [
                        [
                            'id' => 'idValue0',
                            'reference' => 'referenceValue0',
                            'user_id' => 'userIdValue0',
                            'currency' => 'currencyValue0',
                            'is_successful' => true,
                            'completed_at' => 'completedAtValue0',
                            'items' => [
                                [
                                    'id' => 'itemIdValue00',
                                ],
                            ],
                        ],
                    ],
                ]))
            ])
        );

        $di = MockGuzzleClientDi::buildMockDi(MockSession::createWithActiveUserToken(), $mockGuzzleClientFactory);

        $this->expectException(UnexpectedResponseContentException::class);

        $di->getOrdersProvider()->getOrders('cinemaUuid');
    }
}
