<?php

use PHPUnit\Framework\TestCase;
use DCG\Cinema\Validator\ClientResponseDataFieldValidator;

class ClientResponseDataFieldValidatorTest extends TestCase
{

    public function testItReturnsTrueForValidData()
    {
        $SUT = new ClientResponseDataFieldValidator();

        $data = ['test' => '1'];
        $expectedDataFields = ['test'];
        $result = $SUT->validate($data, $expectedDataFields);

        $this->assertEquals(true, $result);
    }

    public function testItReturnsFalseForInValidData()
    {
        $SUT = new ClientResponseDataFieldValidator();

        $data = [];
        $expectedDataFields = ['test'];
        $result = $SUT->validate($data, $expectedDataFields);

        $this->assertEquals(false, $result);
    }
}
