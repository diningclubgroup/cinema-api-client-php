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

class OrderCreatorTest extends TestCase
{
    public function testItReturnsTheExpectedOrderCreationResponse()
    {
        $mockGuzzleClientFactory = new MockGuzzleClientFactory(
            new MockHandler([
                new Response(201, [], json_encode([
                    'data' => [
                        'order_id' => 'orderIdValue',
                        'transaction_id' => 'transactionIdValue',
                        'redirect_url' => 'redirectUrlValue',
                    ],
                ]))
            ])
        );

        $di = MockGuzzleClientDi::buildMockDi(MockSession::createWithActiveUserToken(), $mockGuzzleClientFactory);

        $orderCompletionResponse = $di->getOrderCreator()->createOrder(['dataKey' => 'dataValue']);

        $this->assertEquals('orderIdValue', $orderCompletionResponse->getOrderId());
        $this->assertEquals('transactionIdValue', $orderCompletionResponse->getTransactionId());
        $this->assertEquals('redirectUrlValue', $orderCompletionResponse->getRedirectUrl());

        $requestHistory = $mockGuzzleClientFactory->getHistory();
        $this->assertCount(1, $requestHistory);
        $this->assertEquals('POST', $requestHistory[0]['request']->getMethod());
        $this->assertEquals('orders', (string)$requestHistory[0]['request']->getUri());
        $this->assertEquals(
            ['dataKey' => 'dataValue'],
            json_decode((string)$requestHistory[0]['request']->getBody(), true)
        );
    }

    public function testItThrowsOnUnexpectedStatusCode()
    {
        $di = MockGuzzleClientDi::buildMockDi(
            MockSession::createWithActiveUserToken(),
            new MockGuzzleClientFactory(new MockHandler([new Response(200)]))
        );

        $this->expectException(UnexpectedStatusCodeException::class);

        $di->getOrderCreator()->createOrder([]);
    }

    public function testItThrowsOnUnexpectedResponseContent()
    {
        $di = MockGuzzleClientDi::buildMockDi(
            MockSession::createWithActiveUserToken(),
            new MockGuzzleClientFactory(
                new MockHandler([
                    new Response(201, [], json_encode([
                        'data' => [
                            'order_id' => 'orderIdValue',
                        ],
                    ]))
                ])
            )
        );

        $this->expectException(UnexpectedResponseContentException::class);

        $di->getOrderCreator()->createOrder([]);
    }

    public function testItThrowsOnInactiveUserToken()
    {
        $di = MockGuzzleClientDi::buildMockDi(
            MockSession::createWithInactiveUserToken(),
            new MockGuzzleClientFactory(new MockHandler([]))
        );

        $this->expectException(UserNotAuthenticatedException::class);

        $di->getOrderCreator()->createOrder([]);
    }

    public function testItThrowsOnMissingUserToken()
    {
        $di = MockGuzzleClientDi::buildMockDi(
            MockSession::createWithNoUserToken(),
            new MockGuzzleClientFactory(new MockHandler([]))
        );

        $this->expectException(UserNotAuthenticatedException::class);

        $di->getOrderCreator()->createOrder([]);
    }
}
