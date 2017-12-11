<?php

namespace DCG\Cinema\Tests\Unit\Request;

use DCG\Cinema\Request\RequestSender;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class RequestSenderTest extends MockeryTestCase
{
    public function tearDown()
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testValidRequestWithBody()
    {
        $apiResponseBody = json_encode([
            'meta' => ['metaKey' => 'metaValue'],
            'data' => ['dataKey' => 'dataValue'],
        ]);

        $guzzleResponseMock = Mockery::mock(\GuzzleHttp\Psr7\Response::class);
        $guzzleResponseMock->shouldReceive('getStatusCode')->andReturn(300)->atLeast()->once();
        $guzzleResponseMock->shouldReceive('getBody')->andReturn($apiResponseBody)->atLeast()->once();

        $guzzleClientMock = Mockery::mock(\GuzzleHttp\ClientInterface::class);
        $guzzleClientMock
            ->shouldReceive('request')
            ->with('typeValue', 'pathValue?queryKey=queryValue', ['body' => 'bodyValue'])
            ->andReturn($guzzleResponseMock)
            ->once();

        $requestSender = new RequestSender();
        $result = $requestSender->sendRequest(
            $guzzleClientMock,
            'typeValue',
            'pathValue',
            ['queryKey' => 'queryValue'],
            'bodyValue',
            [300]
        );

        $this->assertInstanceOf('DCG\Cinema\Request\ClientResponse', $result);
        $this->assertEquals(['metaKey' => 'metaValue'], $result->getMeta());
        $this->assertEquals(['dataKey' => 'dataValue'], $result->getData());
    }

    public function testValidRequestWithoutBody()
    {
        $apiResponseBody = json_encode([
            'meta' => ['metaKey' => 'metaValue'],
            'data' => ['dataKey' => 'dataValue'],
        ]);

        $guzzleResponseMock = Mockery::mock(\GuzzleHttp\Psr7\Response::class);
        $guzzleResponseMock->shouldReceive('getStatusCode')->andReturn(300)->atLeast()->once();
        $guzzleResponseMock->shouldReceive('getBody')->andReturn($apiResponseBody)->atLeast()->once();

        $guzzleClientMock = Mockery::mock(\GuzzleHttp\ClientInterface::class);
        $guzzleClientMock
            ->shouldReceive('request')
            ->with('typeValue', 'pathValue?queryKey=queryValue', [])
            ->andReturn($guzzleResponseMock)
            ->once();

        $requestSender = new RequestSender();
        $result = $requestSender->sendRequest(
            $guzzleClientMock,
            'typeValue',
            'pathValue',
            ['queryKey' => 'queryValue'],
            null,
            [300]
        );

        $this->assertInstanceOf('DCG\Cinema\Request\ClientResponse', $result);
        $this->assertEquals(['metaKey' => 'metaValue'], $result->getMeta());
        $this->assertEquals(['dataKey' => 'dataValue'], $result->getData());
    }

    public function testThrowsWithUnexpectedStatusCode()
    {
        $guzzleResponseMock = Mockery::mock(\GuzzleHttp\Psr7\Response::class);
        $guzzleResponseMock->shouldReceive('getStatusCode')->andReturn(300)->atLeast()->once();
        $guzzleResponseMock->shouldNotReceive('getBody');

        $guzzleClientMock = Mockery::mock(\GuzzleHttp\ClientInterface::class);
        $guzzleClientMock
            ->shouldReceive('request')
            ->with('typeValue', 'pathValue', [])
            ->andReturn($guzzleResponseMock)
            ->once();

        $this->expectException('DCG\Cinema\Exception\UnexpectedStatusCodeException');

        $requestSender = new RequestSender();
        $requestSender->sendRequest(
            $guzzleClientMock,
            'typeValue',
            'pathValue',
            [],
            null,
            [200]
        );
    }
}