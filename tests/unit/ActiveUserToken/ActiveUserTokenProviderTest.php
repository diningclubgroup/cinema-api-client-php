<?php

namespace DCG\Cinema\Tests\Unit\ActiveUserToken;

use DCG\Cinema\ActiveUserToken\ActiveUserToken;
use DCG\Cinema\ActiveUserToken\ActiveUserTokenProvider;
use DCG\Cinema\Model\UserToken;
use DCG\Cinema\Session\SessionInterface;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class ActiveUserTokenProviderTest extends MockeryTestCase
{
    public function tearDown()
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testReturnsActiveToken()
    {
        $userToken = new UserToken('tokenValue', time() + 100);

        $sessionMock = Mockery::mock(SessionInterface::class);
        $sessionMock->shouldReceive('get')->with(ActiveUserToken::SESSION_KEY_NAME)->andReturn($userToken)->once();

        $activeUserTokenProvider = new ActiveUserTokenProvider($sessionMock);
        $result = $activeUserTokenProvider->getUserToken();

        $this->assertEquals($userToken, $result);
    }

    public function testReturnsNullOnMissingToken()
    {
        $sessionMock = Mockery::mock(SessionInterface::class);
        $sessionMock->shouldReceive('get')->with(ActiveUserToken::SESSION_KEY_NAME)->andReturn(null)->once();

        $activeUserTokenProvider = new ActiveUserTokenProvider($sessionMock);
        $result = $activeUserTokenProvider->getUserToken();

        $this->assertNull($result);
    }

    public function testReturnsNullOnExpiredToken()
    {
        $userToken = new UserToken('tokenValue', time() - 100);

        $sessionMock = Mockery::mock(SessionInterface::class);
        $sessionMock->shouldReceive('get')->with(ActiveUserToken::SESSION_KEY_NAME)->andReturn($userToken)->once();

        $activeUserTokenProvider = new ActiveUserTokenProvider($sessionMock);
        $result = $activeUserTokenProvider->getUserToken();

        $this->assertNull($result);
    }
}
