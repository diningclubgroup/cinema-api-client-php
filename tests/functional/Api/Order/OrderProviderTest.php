<?php

namespace DCG\Cinema\Tests\Functional\Api\Order;

use DCG\Cinema\Exception\UnexpectedResponseContentException;
use DCG\Cinema\Exception\UnexpectedStatusCodeException;
use DCG\Cinema\Exception\UserNotAuthenticatedException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use DCG\Cinema\Tests\Functional\Mocks\MockGuzzleClientDi;
use DCG\Cinema\Tests\Functional\Mocks\MockGuzzleClientFactory;
use DCG\Cinema\Tests\Functional\Mocks\MockSession;

class OrderProviderTest extends TestCase
{
    public function testItReturnsTheExpectedOrder()
    {
        $mockGuzzleClientFactory = new MockGuzzleClientFactory(
            new MockHandler([
                new Response(200, [], json_encode([
                    'data' => [
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
                ]))
            ])
        );

        $di = MockGuzzleClientDi::buildMockDi(MockSession::createWithActiveUserToken(), $mockGuzzleClientFactory);

        $order = $di->getOrderProvider()->getOrder('orderIdValue');

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

        $requestHistory = $mockGuzzleClientFactory->getHistory();
        $this->assertCount(1, $requestHistory);
        $this->assertEquals('GET', $requestHistory[0]['request']->getMethod());
        $this->assertEquals('orders/orderIdValue', (string)$requestHistory[0]['request']->getUri());
    }

    public function testItThrowsOnUnexpectedStatusCode()
    {
        $di = MockGuzzleClientDi::buildMockDi(
            MockSession::createWithActiveUserToken(),
            new MockGuzzleClientFactory(new MockHandler([new Response(201)]))
        );

        $this->expectException(UnexpectedStatusCodeException::class);

        $di->getOrderProvider()->getOrder('orderId');
    }

    public function testItThrowsOnUnexpectedResponseContent()
    {
        $di = MockGuzzleClientDi::buildMockDi(
            MockSession::createWithActiveUserToken(),
            new MockGuzzleClientFactory(
                new MockHandler([
                    new Response(200, [], json_encode([
                        'data' => [
                            'id' => 'idValue0',
                        ],
                    ]))
                ])
            )
        );

        $this->expectException(UnexpectedResponseContentException::class);

        $di->getOrderProvider()->getOrder('orderId');
    }

    public function testItThrowsOnUnexpectedItemContent()
    {
        $mockGuzzleClientFactory = new MockGuzzleClientFactory(
            new MockHandler([
                new Response(200, [], json_encode([
                    'data' => [
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
                ]))
            ])
        );

        $di = MockGuzzleClientDi::buildMockDi(MockSession::createWithActiveUserToken(), $mockGuzzleClientFactory);

        $this->expectException(UnexpectedResponseContentException::class);

        $di->getOrderProvider()->getOrder('orderId');
    }

    public function testItThrowsOnInactiveUserToken()
    {
        $di = MockGuzzleClientDi::buildMockDi(
            MockSession::createWithInactiveUserToken(),
            new MockGuzzleClientFactory(new MockHandler([]))
        );

        $this->expectException(UserNotAuthenticatedException::class);

        $di->getOrderProvider()->getOrder('orderId');
    }

    public function testItThrowsOnMissingUserToken()
    {
        $di = MockGuzzleClientDi::buildMockDi(
            MockSession::createWithNoUserToken(),
            new MockGuzzleClientFactory(new MockHandler([]))
        );

        $this->expectException(UserNotAuthenticatedException::class);

        $di->getOrderProvider()->getOrder('orderId');
    }
}
