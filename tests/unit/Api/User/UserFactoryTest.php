<?php

namespace Api\User;

use PHPUnit\Framework\TestCase;
use DCG\Cinema\Validator\ClientResponseDataFieldValidator;
use DCG\Cinema\Api\User\UserFactory;
use DCG\Cinema\Exception\UnexpectedResponseContentException;

class UserFactoryTest extends TestCase
{

    public function testItReturnsAValidUser()
    {
        $validator = new ClientResponseDataFieldValidator();
        $SUT = new UserFactory($validator);
        $data = [
            'id' => "test_id",
            'firstname' => "test_firstname",
            'surname' => "test_surname",
            'email' => "test_email"
        ];

        $result = $SUT->createFromClientResponseData($data);

        $this->assertEquals("test_id", $result->getId());
        $this->assertEquals("test_firstname", $result->getFirstName());
        $this->assertEquals("test_surname", $result->getSurname());
        $this->assertEquals("test_email", $result->getEmail());
    }

    public function testItThrowsExceptionOnInvalidInputs()
    {
        $validator = new ClientResponseDataFieldValidator();
        $SUT = new UserFactory($validator);
        $data = [];

        $this->expectException(UnexpectedResponseContentException::class);

        $SUT->createFromClientResponseData($data);
    }
}
