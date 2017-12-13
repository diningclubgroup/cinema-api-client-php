<?php

namespace DCG\Cinema\Tests\Unit\Api\UserToken;

use PHPUnit\Framework\TestCase;
use DCG\Cinema\Validator\ClientResponseDataFieldValidator;
use DCG\Cinema\Api\UserToken\UserTokenFactory;
use DCG\Cinema\Exception\UnexpectedResponseContentException;

class UserTokenFactoryTest extends TestCase
{

    public function testItReturnsAValidUserToken()
    {
        $validator = new ClientResponseDataFieldValidator();
        $SUT = new UserTokenFactory($validator);
        $data = [
            'token' => "test_token",
            'expiration_date' => "2017-01-01"
        ];

        $result = $SUT->createFromClientResponseData($data);

        $this->assertEquals("test_token", $result->getToken());
        $this->assertEquals("1483228800", $result->getExpirationUnixTime());
    }

    public function testItThrowsExceptionOnInvalidInputs()
    {
        $validator = new ClientResponseDataFieldValidator();
        $SUT = new UserTokenFactory($validator);
        $data = [];

        $this->expectException(UnexpectedResponseContentException::class);
        $SUT->createFromClientResponseData($data);
    }
}
