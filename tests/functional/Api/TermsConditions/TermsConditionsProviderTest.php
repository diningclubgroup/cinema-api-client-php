<?php

namespace Tests\Functional\Api\TermsConditions;

use DCG\Cinema\Exception\UnexpectedResponseContentException;
use DCG\Cinema\Exception\UnexpectedStatusCodeException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use Tests\Functional\Mocks\MockGuzzleClientDi;
use Tests\Functional\Mocks\MockGuzzleClientFactory;
use Tests\Functional\Mocks\MockSession;

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
}
