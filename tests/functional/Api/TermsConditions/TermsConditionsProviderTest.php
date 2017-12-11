<?php

namespace DCG\Cinema\Tests\Functional\Api\TermsConditions;

use DCG\Cinema\Exception\UnexpectedResponseContentException;
use DCG\Cinema\Exception\UnexpectedStatusCodeException;
use DCG\Cinema\Exception\UserNotAuthenticatedException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use DCG\Cinema\Tests\Functional\Mocks\MockGuzzleClientDi;
use DCG\Cinema\Tests\Functional\Mocks\MockGuzzleClientFactory;
use DCG\Cinema\Tests\Functional\Mocks\MockSession;

class TermsConditionsProviderTest extends TestCase
{
    public function testItReturnsTheExpectedTermsConditions()
    {
        $mockGuzzleClientFactory = new MockGuzzleClientFactory(
            new MockHandler([
                new Response(200, [], json_encode([
                    'data' => [
                        'content' => 'contentValue',
                    ],
                ]))
            ])
        );

        $di = MockGuzzleClientDi::buildMockDi(MockSession::createWithActiveUserToken(), $mockGuzzleClientFactory);

        $termsConditions = $di->getTermsConditionsProvider()->getTermsConditions();

        $this->assertEquals('contentValue', $termsConditions->getContent());

        $requestHistory = $mockGuzzleClientFactory->getHistory();
        $this->assertCount(1, $requestHistory);
        $this->assertEquals('GET', $requestHistory[0]['request']->getMethod());
        $this->assertEquals('terms-and-conditions', (string)$requestHistory[0]['request']->getUri());
    }

    public function testItThrowsOnUnexpectedStatusCode()
    {
        $di = MockGuzzleClientDi::buildMockDi(
            MockSession::createWithActiveUserToken(),
            new MockGuzzleClientFactory(new MockHandler([new Response(201)]))
        );

        $this->expectException(UnexpectedStatusCodeException::class);

        $di->getTermsConditionsProvider()->getTermsConditions();
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

        $di->getTermsConditionsProvider()->getTermsConditions();
    }

    public function testItThrowsOnInactiveUserToken()
    {
        $di = MockGuzzleClientDi::buildMockDi(
            MockSession::createWithInactiveUserToken(),
            new MockGuzzleClientFactory(new MockHandler([]))
        );

        $this->expectException(UserNotAuthenticatedException::class);

        $di->getTermsConditionsProvider()->getTermsConditions();
    }

    public function testItThrowsOnMissingUserToken()
    {
        $di = MockGuzzleClientDi::buildMockDi(
            MockSession::createWithNoUserToken(),
            new MockGuzzleClientFactory(new MockHandler([]))
        );

        $this->expectException(UserNotAuthenticatedException::class);

        $di->getTermsConditionsProvider()->getTermsConditions();
    }
}
