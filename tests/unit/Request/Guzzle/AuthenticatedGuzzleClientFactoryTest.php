<?php

namespace DCG\Cinema\Tests\Unit\Request\Guzzle;

use DCG\Cinema\ActiveUserToken\ActiveUserTokenProvider;
use DCG\Cinema\Exception\UserNotAuthenticatedException;
use DCG\Cinema\Model\UserToken;
use DCG\Cinema\Request\Guzzle\AuthenticatedGuzzleClientFactory;
use DCG\Cinema\Request\Guzzle\GuzzleClientFactoryInterface;
use GuzzleHttp\Client;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class AuthenticatedGuzzleClientFactoryTest extends MockeryTestCase
{
    public function tearDown()
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testSuccessOnValidUserToken()
    {
        $client = new Client();
        $userToken = new UserToken('userTokenValue', 0);

        $guzzleClientFactoryMock = Mockery::mock(GuzzleClientFactoryInterface::class);
        $guzzleClientFactoryMock
            ->shouldReceive('create')
            ->with(['k' => 'v', 'User-Token' => 'userTokenValue'])
            ->andReturn($client)
            ->once();

        $activeUserTokenProviderMock = Mockery::mock(ActiveUserTokenProvider::class);
        $activeUserTokenProviderMock->shouldReceive('getUserToken')->andReturn($userToken);

        $authenticatedGuzzleClientFactory = new AuthenticatedGuzzleClientFactory(
            $guzzleClientFactoryMock,
            $activeUserTokenProviderMock
        );
        $result = $authenticatedGuzzleClientFactory->create(['k' => 'v']);

        $this->assertEquals($client, $result);
    }

    public function testThrowsOnInvalidUserToken()
    {
        $guzzleClientFactoryMock = Mockery::mock(GuzzleClientFactoryInterface::class);

        $activeUserTokenProviderMock = Mockery::mock(ActiveUserTokenProvider::class);
        $activeUserTokenProviderMock->shouldReceive('getUserToken')->andReturn(null);

        $authenticatedGuzzleClientFactory = new AuthenticatedGuzzleClientFactory(
            $guzzleClientFactoryMock,
            $activeUserTokenProviderMock
        );

        $this->expectException(UserNotAuthenticatedException::class);
        $result = $authenticatedGuzzleClientFactory->create(['k' => 'v']);
    }
}
