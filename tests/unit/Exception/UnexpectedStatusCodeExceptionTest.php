<?php

namespace DCG\Cinema\Tests\Exception;

use DCG\Cinema\Exception\UnexpectedStatusCodeException;
use PHPUnit\Framework\TestCase;

class UnexpectedStatusCodeExceptionTest extends TestCase
{
    public function testConstructorWithMessageAndPrevious()
    {
        $previous = new \RuntimeException();

        $e = new UnexpectedStatusCodeException(123, 'Test message', $previous);

        $this->assertEquals(123, $e->getCode());
        $this->assertEquals('Test message', $e->getMessage());
        $this->assertEquals($previous, $e->getPrevious());
    }

    public function testConstructorWithNullMessage()
    {
        $e = new UnexpectedStatusCodeException(123);

        $this->assertEquals(123, $e->getCode());
        $this->assertRegExp('/123/', $e->getMessage());
    }
}
