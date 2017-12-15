<?php

namespace DCG\Cinema\Tests\Unit\Request\Client;

use DCG\Cinema\Request\Client\Getter;
use DCG\Cinema\Request\ClientResponse;
use DCG\Cinema\Request\Guzzle\GuzzleClientFactoryInterface;
use DCG\Cinema\Request\RequestSender;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class GetterTest extends MockeryTestCase
{
    public function tearDown()
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testGetSuccess()
    {
        $clientResponse = new ClientResponse(['metaKey' => 'metaValue'], ['dataKey' => 'dataValue']);

        $guzzleClientMock = Mockery::mock(\GuzzleHttp\ClientInterface::class);

        $guzzleClientFactoryMock = Mockery::mock(GuzzleClientFactoryInterface::class);
        $guzzleClientFactoryMock->shouldReceive('create')->andReturn($guzzleClientMock)->once();

        $requestSenderMock = Mockery::mock(RequestSender::class);
        $requestSenderMock
            ->shouldReceive('sendRequest')
            ->with($guzzleClientMock, 'GET', 'pathValue', ['queryKey' => 'queryValue'], null, [300])
            ->andReturn($clientResponse)
            ->once();

        $getter = new Getter($guzzleClientFactoryMock, $requestSenderMock);
        $result = $getter->get('pathValue', ['queryKey' => 'queryValue'], [300]);

        $this->assertEquals($clientResponse, $result);
    }
}
