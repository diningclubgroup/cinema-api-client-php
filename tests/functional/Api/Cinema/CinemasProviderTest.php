<?php

namespace DCG\Cinema\Tests\Functional\Api\Cinema;

use DCG\Cinema\Exception\UnexpectedResponseContentException;
use DCG\Cinema\Exception\UnexpectedStatusCodeException;
use DCG\Cinema\Exception\UserNotAuthenticatedException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use DCG\Cinema\Tests\Functional\Mocks\MockGuzzleClientDi;
use DCG\Cinema\Tests\Functional\Mocks\MockGuzzleClientFactory;
use DCG\Cinema\Tests\Functional\Mocks\MockSession;

class CinemasProviderTest extends TestCase
{
    public function testItReturnsTheExpectedCinemas()
    {
        $mockGuzzleClientFactory = new MockGuzzleClientFactory(
            new MockHandler([
                new Response(200, [], json_encode([
                    'data' => [
                        [
                            'id' => 'idValue0',
                            'name' => 'nameValue0',
                            'is_exempt' => true,
                            'location_id' => 'locationValue0',
                        ],
                        [
                            'id' => 'idValue1',
                            'name' => 'nameValue1',
                            'is_exempt' => false,
                            'location_id' => 'locationValue1',
                        ],
                    ],
                ]))
            ])
        );

        $di = MockGuzzleClientDi::buildMockDi(MockSession::createWithActiveUserToken(), $mockGuzzleClientFactory);

        $cinemas = $di->getCinemasProvider()->getCinemas('chainIdValue');

        $this->assertCount(2, $cinemas);

        $this->assertEquals('idValue0', $cinemas[0]->getId());
        $this->assertEquals('nameValue0', $cinemas[0]->getName());
        $this->assertEquals(true, $cinemas[0]->getIsExempt());
        $this->assertEquals('locationValue0', $cinemas[0]->getLocationId());

        $this->assertEquals('idValue1', $cinemas[1]->getId());
        $this->assertEquals('nameValue1', $cinemas[1]->getName());
        $this->assertEquals(false, $cinemas[1]->getIsExempt());
        $this->assertEquals('locationValue1', $cinemas[1]->getLocationId());

        $requestHistory = $mockGuzzleClientFactory->getHistory();
        $this->assertCount(1, $requestHistory);
        $this->assertEquals('GET', $requestHistory[0]['request']->getMethod());
        $this->assertEquals('chains/chainIdValue/cinemas', (string)$requestHistory[0]['request']->getUri());
    }

    public function testItThrowsOnUnexpectedStatusCode()
    {
        $di = MockGuzzleClientDi::buildMockDi(
            MockSession::createWithActiveUserToken(),
            new MockGuzzleClientFactory(new MockHandler([new Response(201)]))
        );

        $this->expectException(UnexpectedStatusCodeException::class);

        $di->getCinemasProvider()->getCinemas('chainId');
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

        $di->getCinemasProvider()->getCinemas('chainId');
    }

    public function testItThrowsOnInactiveUserToken()
    {
        $di = MockGuzzleClientDi::buildMockDi(
            MockSession::createWithInactiveUserToken(),
            new MockGuzzleClientFactory(new MockHandler([]))
        );

        $this->expectException(UserNotAuthenticatedException::class);

        $di->getCinemasProvider()->getCinemas('chainId');
    }

    public function testItThrowsOnMissingUserToken()
    {
        $di = MockGuzzleClientDi::buildMockDi(
            MockSession::createWithNoUserToken(),
            new MockGuzzleClientFactory(new MockHandler([]))
        );

        $this->expectException(UserNotAuthenticatedException::class);

        $di->getCinemasProvider()->getCinemas('chainId');
    }
}
