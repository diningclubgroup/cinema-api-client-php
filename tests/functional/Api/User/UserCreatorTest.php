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

class UserCreatorTest extends TestCase
{
    public function testItReturnsTheExpectedUser()
    {
        $mockGuzzleClientFactory = new MockGuzzleClientFactory(
            new MockHandler([
                new Response(201, [], json_encode([
                    'data' => [
                        'id' => 'idValue',
                        'firstname' => 'firstNameValue',
                        'surname' => 'surnameValue',
                        'email' => 'emailValue',
                    ],
                ]))
            ])
        );

        $di = MockGuzzleClientDi::buildMockDi(MockSession::createWithNoUserToken(), $mockGuzzleClientFactory);

        $user = $di->getUserCreator()->createUser(['dataKey' => 'dataValue']);

        $this->assertEquals('idValue', $user->getId());
        $this->assertEquals('firstNameValue', $user->getFirstName());
        $this->assertEquals('surnameValue', $user->getSurname());
        $this->assertEquals('emailValue', $user->getEmail());

        $requestHistory = $mockGuzzleClientFactory->getHistory();
        $this->assertCount(1, $requestHistory);
        $this->assertEquals('POST', $requestHistory[0]['request']->getMethod());
        $this->assertEquals('users', (string)$requestHistory[0]['request']->getUri());
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
        $this->expectExceptionCode(200);

        $di->getUserCreator()->createUser([]);
    }

    public function testItThrowsOnUnexpectedResponseContent()
    {
        $di = MockGuzzleClientDi::buildMockDi(
            MockSession::createWithActiveUserToken(),
            new MockGuzzleClientFactory(
                new MockHandler([
                    new Response(201, [], json_encode([
                        'data' => [
                            'id' => 'idValue',
                        ],
                    ]))
                ])
            )
        );

        $this->expectException(UnexpectedResponseContentException::class);

        $di->getUserCreator()->createUser([]);
    }
}
