<?php

namespace DCG\Cinema\Tests\Unit\ActiveUserToken;

use DCG\Cinema\ActiveUserToken\ActiveUserToken;
use DCG\Cinema\ActiveUserToken\ActiveUserTokenPersister;
use DCG\Cinema\Model\UserToken;
use DCG\Cinema\Session\SessionInterface;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class ActiveUserTokenPersisterTest extends MockeryTestCase
{
    public function tearDown()
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testPersistsUserToken()
    {
        $userToken = new UserToken('tokenValue', 1000);

        $sessionMock = Mockery::mock(SessionInterface::class);
        $sessionMock->shouldReceive('set')->with(ActiveUserToken::SESSION_KEY_NAME, $userToken)->once();

        $activeUserTokenPersister = new ActiveUserTokenPersister($sessionMock);
        $activeUserTokenPersister->persistUserToken($userToken);
    }
}
