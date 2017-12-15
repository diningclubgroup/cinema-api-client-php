<?php

namespace DCG\Cinema\Tests\Unit\Request\Client;

use DCG\Cinema\Cache\CacheInterface;
use DCG\Cinema\Request\Cache\KeyGenerator;
use DCG\Cinema\Request\Cache\LifetimeGenerator;
use DCG\Cinema\Request\Client\CachingGetter;
use DCG\Cinema\Request\Client\GetterInterface;
use DCG\Cinema\Request\ClientResponse;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class CachingGetterTest extends MockeryTestCase
{
    public function tearDown()
    {
        Mockery::close();
        parent::tearDown();
    }

    public function testGetReturnsCachedItem()
    {
        $clientResponse = new ClientResponse(
            ['metaKey' => 'metaValue'],
            ['dataKey' => 'dataValue']
        );

        $getterMock = Mockery::mock(GetterInterface::class);

        $keyGeneratorMock = Mockery::mock(KeyGenerator::class);
        $keyGeneratorMock
            ->shouldReceive('generateKey')
            ->with('get', 'pathValue', ['k' => 'v'], [200, 201])
            ->andReturn('keyValue')
            ->atLeast()
            ->once();

        $lifetimeGeneratorMock = Mockery::mock(LifetimeGenerator::class);

        $cacheMock = Mockery::mock(CacheInterface::class);
        $cacheMock->shouldReceive('get')->with('keyValue')->andReturn($clientResponse)->once();

        $cachingClient = new CachingGetter($getterMock, $cacheMock, $keyGeneratorMock, $lifetimeGeneratorMock);
        $result = $cachingClient->get('pathValue', ['k' => 'v'], [200, 201]);

        $this->assertEquals($clientResponse, $result);
    }

    public function testGetCachesAndReturnsItem()
    {
        $clientResponse = new ClientResponse(
            ['metaKey' => 'metaValue'],
            ['dataKey' => 'dataValue']
        );

        $getterMock = Mockery::mock(GetterInterface::class);
        $getterMock
            ->shouldReceive('get')
            ->with('pathValue', ['k' => 'v'], [200, 201])
            ->andReturn($clientResponse)
            ->once();

        $keyGeneratorMock = Mockery::mock(KeyGenerator::class);
        $keyGeneratorMock
            ->shouldReceive('generateKey')
            ->with('get', 'pathValue', ['k' => 'v'], [200, 201])
            ->andReturn('keyValue')
            ->atLeast()
            ->once();

        $lifetimeGeneratorMock = Mockery::mock(LifetimeGenerator::class);
        $lifetimeGeneratorMock->shouldReceive('generateLifetimeSeconds')->andReturn(10)->atLeast()->once();

        $cacheMock = Mockery::mock(CacheInterface::class);
        $cacheMock->shouldReceive('get')->with('keyValue')->andReturn(null)->once();
        $cacheMock->shouldReceive('set')->with('keyValue', $clientResponse, 10)->once();

        $cachingClient = new CachingGetter($getterMock, $cacheMock, $keyGeneratorMock, $lifetimeGeneratorMock);
        $result = $cachingClient->get('pathValue', ['k' => 'v'], [200, 201]);

        $this->assertEquals($clientResponse, $result);
    }
}
