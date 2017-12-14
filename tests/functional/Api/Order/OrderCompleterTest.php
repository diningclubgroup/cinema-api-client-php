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

class OrderCompleterTest extends TestCase
{
    public function testItReturnsTheExpectedOrderCompletionResponse()
    {
        $mockGuzzleClientFactory = new MockGuzzleClientFactory(
            new MockHandler([
                new Response(200, [], json_encode([
                    'data' => [
                        'id' => 'idValue',
                        'status_code' => 'statusCodeValue',
                        'status_message' => 'statusMessageValue',
                        'is_successful' => 'isSuccessfulValue',
                        'order_id' => 'orderIdValue',
                    ],
                ]))
            ])
        );

        $di = MockGuzzleClientDi::buildMockDi(MockSession::createWithActiveUserToken(), $mockGuzzleClientFactory);

        $orderCompletionResponse = $di->getOrderCompleter()->completeOrder(
            'transactionIdValue',
            ['dataKey' => 'dataValue']
        );

        $this->assertEquals('idValue', $orderCompletionResponse->getId());
        $this->assertEquals('statusCodeValue', $orderCompletionResponse->getStatusCode());
        $this->assertEquals('statusMessageValue', $orderCompletionResponse->getStatusMessage());
        $this->assertEquals('isSuccessfulValue', $orderCompletionResponse->getIsSuccessful());
        $this->assertEquals('orderIdValue', $orderCompletionResponse->getOrderId());

        $requestHistory = $mockGuzzleClientFactory->getHistory();
        $this->assertCount(1, $requestHistory);
        $this->assertEquals('PATCH', $requestHistory[0]['request']->getMethod());
        $this->assertEquals('transactions/transactionIdValue', (string)$requestHistory[0]['request']->getUri());
        $this->assertEquals(
            ['dataKey' => 'dataValue'],
            json_decode((string)$requestHistory[0]['request']->getBody(), true)
        );
    }

    public function testItThrowsOnUnexpectedStatusCode()
    {
        $di = MockGuzzleClientDi::buildMockDi(
            MockSession::createWithActiveUserToken(),
            new MockGuzzleClientFactory(new MockHandler([new Response(201)]))
        );

        $this->expectException(UnexpectedStatusCodeException::class);
        $this->expectExceptionCode(201);

        $di->getOrderCompleter()->completeOrder('transactionId', []);
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

        $di->getOrderCompleter()->completeOrder('transactionId', []);
    }

    public function testItThrowsOnInactiveUserToken()
    {
        $di = MockGuzzleClientDi::buildMockDi(
            MockSession::createWithInactiveUserToken(),
            new MockGuzzleClientFactory(new MockHandler([]))
        );

        $this->expectException(UserNotAuthenticatedException::class);

        $di->getOrderCompleter()->completeOrder('transactionId', []);
    }

    public function testItThrowsOnMissingUserToken()
    {
        $di = MockGuzzleClientDi::buildMockDi(
            MockSession::createWithNoUserToken(),
            new MockGuzzleClientFactory(new MockHandler([]))
        );

        $this->expectException(UserNotAuthenticatedException::class);

        $di->getOrderCompleter()->completeOrder('transactionId', []);
    }
}
