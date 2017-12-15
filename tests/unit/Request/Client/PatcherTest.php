<?php

namespace DCG\Cinema\Tests\Unit\Request\Client;

use DCG\Cinema\Request\Client\Patcher;
use DCG\Cinema\Request\ClientResponse;
use DCG\Cinema\Request\Guzzle\GuzzleClientFactoryInterface;
use DCG\Cinema\Request\RequestSender;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class PatcherTest extends MockeryTestCase
{
    public function tearDown()
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testPatchSuccess()
    {
        $clientResponse = new ClientResponse(['metaKey' => 'metaValue'], ['dataKey' => 'dataValue']);

        $guzzleClientMock = Mockery::mock(\GuzzleHttp\ClientInterface::class);

        $guzzleClientFactoryMock = Mockery::mock(GuzzleClientFactoryInterface::class);
        $guzzleClientFactoryMock->shouldReceive('create')->andReturn($guzzleClientMock)->once();

        $requestSenderMock = Mockery::mock(RequestSender::class);
        $requestSenderMock
            ->shouldReceive('sendRequest')
            ->with($guzzleClientMock, 'PATCH', 'pathValue', [], 'bodyValue', [300])
            ->andReturn($clientResponse)
            ->once();

        $patcher = new Patcher($guzzleClientFactoryMock, $requestSenderMock);
        $result = $patcher->patch('pathValue', 'bodyValue', [300]);

        $this->assertEquals($clientResponse, $result);
    }
}
