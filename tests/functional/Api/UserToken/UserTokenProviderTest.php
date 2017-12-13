<?php

namespace DCG\Cinema\Tests\Functional\Api\UserToken;

use DCG\Cinema\Exception\UnexpectedResponseContentException;
use DCG\Cinema\Exception\UnexpectedStatusCodeException;
use DCG\Cinema\Exception\UserNotAuthenticatedException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use DCG\Cinema\Tests\Functional\Mocks\MockGuzzleClientDi;
use DCG\Cinema\Tests\Functional\Mocks\MockGuzzleClientFactory;
use DCG\Cinema\Tests\Functional\Mocks\MockSession;

class UserTokenProviderTest extends TestCase
{
    public function testItReturnsTheExpectedUserToken()
    {
        $mockGuzzleClientFactory = new MockGuzzleClientFactory(
            new MockHandler([
                new Response(201, [], json_encode([
                    'data' => [
                        'token' => 'tokenValue',
                        'expiration_date' => '2017-01-01T12:30:00+00:00',
                    ],
                ]))
            ])
        );

        $di = MockGuzzleClientDi::buildMockDi(MockSession::createWithNoUserToken(), $mockGuzzleClientFactory);

        $user = $di->getUserTokenProvider()->getToken('userIdValue');

        $this->assertEquals('tokenValue', $user->getToken());
        $this->assertEquals(strtotime('2017-01-01T12:30:00+00:00'), $user->getExpirationUnixTime());

        $requestHistory = $mockGuzzleClientFactory->getHistory();
        $this->assertCount(1, $requestHistory);
        $this->assertEquals('POST', $requestHistory[0]['request']->getMethod());
        $this->assertEquals('users/userIdValue/tokens', (string)$requestHistory[0]['request']->getUri());
    }

    public function testItThrowsOnUnexpectedStatusCode()
    {
        $di = MockGuzzleClientDi::buildMockDi(
            MockSession::createWithActiveUserToken(),
            new MockGuzzleClientFactory(new MockHandler([new Response(200)]))
        );

        $this->expectException(UnexpectedStatusCodeException::class);

        $di->getUserTokenProvider()->getToken('userId');
    }

    public function testItThrowsOnUnexpectedResponseContent()
    {
        $di = MockGuzzleClientDi::buildMockDi(
            MockSession::createWithActiveUserToken(),
            new MockGuzzleClientFactory(
                new MockHandler([
                    new Response(201, [], json_encode([
                        'data' => [
                            'token' => 'tokenValue',
                        ],
                    ]))
                ])
            )
        );

        $this->expectException(UnexpectedResponseContentException::class);

        $di->getUserTokenProvider()->getToken('userId');
    }
}
