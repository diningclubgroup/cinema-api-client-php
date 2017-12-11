<?php

namespace DCG\Cinema\Tests\Functional\Api\User;

use DCG\Cinema\Exception\UnexpectedResponseContentException;
use DCG\Cinema\Exception\UnexpectedStatusCodeException;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use DCG\Cinema\Tests\Functional\Mocks\MockGuzzleClientDi;
use DCG\Cinema\Tests\Functional\Mocks\MockGuzzleClientFactory;
use DCG\Cinema\Tests\Functional\Mocks\MockSession;

class UserProviderTest extends TestCase
{
    public function testItReturnsTheExpectedUser()
    {
        $mockGuzzleClientFactory = new MockGuzzleClientFactory(
            new MockHandler([
                new Response(200, [], json_encode([
                    'data' => [
                        [
                            'id' => 'idValue',
                            'firstname' => 'firstNameValue',
                            'surname' => 'surnameValue',
                            'email' => 'emailValue',
                        ],
                    ],
                ]))
            ])
        );

        $di = MockGuzzleClientDi::buildMockDi(MockSession::createWithNoUserToken(), $mockGuzzleClientFactory);

        $user = $di->getUserProvider()->getUserByEmail('emailValueIn');

        $this->assertEquals('idValue', $user->getId());
        $this->assertEquals('firstNameValue', $user->getFirstName());
        $this->assertEquals('surnameValue', $user->getSurname());
        $this->assertEquals('emailValue', $user->getEmail());

        $requestHistory = $mockGuzzleClientFactory->getHistory();
        $this->assertCount(1, $requestHistory);
        $this->assertEquals('GET', $requestHistory[0]['request']->getMethod());
        $this->assertEquals('users?email=emailValueIn', (string)$requestHistory[0]['request']->getUri());
    }

    public function testItThrowsOnUserNotFound()
    {
        $di = MockGuzzleClientDi::buildMockDi(
            MockSession::createWithActiveUserToken(),
            new MockGuzzleClientFactory(
                new MockHandler([
                    new Response(200, [], json_encode([
                        'data' => [],
                    ]))
                ])
            )
        );

        $this->expectException(\RuntimeException::class);

        $di->getUserProvider()->getUserByEmail('emailValue');
    }

    public function testItThrowsOnUnexpectedStatusCode()
    {
        $di = MockGuzzleClientDi::buildMockDi(
            MockSession::createWithActiveUserToken(),
            new MockGuzzleClientFactory(new MockHandler([new Response(201)]))
        );

        $this->expectException(UnexpectedStatusCodeException::class);

        $di->getUserProvider()->getUserByEmail('emailValue');
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
                            ]
                        ],
                    ]))
                ])
            )
        );

        $this->expectException(UnexpectedResponseContentException::class);

        $di->getUserProvider()->getUserByEmail('emailValue');
    }
}
