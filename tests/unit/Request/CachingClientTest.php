<?php

namespace DCG\Cinema\Tests\Unit\Request;

use DCG\Cinema\Cache\CacheInterface;
use DCG\Cinema\Request\Cache\KeyGenerator;
use DCG\Cinema\Request\Cache\LifetimeGenerator;
use DCG\Cinema\Request\CachingClient;
use DCG\Cinema\Request\ClientInterface;
use DCG\Cinema\Request\ClientResponse;
use Mockery;
use Mockery\Adapter\Phpunit\MockeryTestCase;

class CachingClientTest extends MockeryTestCase
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

        $clientMock = Mockery::mock(ClientInterface::class);

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

        $cachingClient = new CachingClient($clientMock, $cacheMock, $keyGeneratorMock, $lifetimeGeneratorMock);
        $result = $cachingClient->get('pathValue', ['k' => 'v'], [200, 201]);

        $this->assertEquals($clientResponse, $result);
    }

    public function testGetCachesAndReturnsItem()
    {
        $clientResponse = new ClientResponse(
            ['metaKey' => 'metaValue'],
            ['dataKey' => 'dataValue']
        );

        $clientMock = Mockery::mock(ClientInterface::class);
        $clientMock
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

        $cachingClient = new CachingClient($clientMock, $cacheMock, $keyGeneratorMock, $lifetimeGeneratorMock);
        $result = $cachingClient->get('pathValue', ['k' => 'v'], [200, 201]);

        $this->assertEquals($clientResponse, $result);
    }

    public function testGetUnauthenticatedReturnsCachedItem()
    {
        $clientResponse = new ClientResponse(
            ['metaKey' => 'metaValue'],
            ['dataKey' => 'dataValue']
        );

        $clientMock = Mockery::mock(ClientInterface::class);

        $keyGeneratorMock = Mockery::mock(KeyGenerator::class);
        $keyGeneratorMock
            ->shouldReceive('generateKey')
            ->with('getUnauthenticated', 'pathValue', ['k' => 'v'], [200, 201])
            ->andReturn('keyValue')
            ->atLeast()
            ->once();

        $lifetimeGeneratorMock = Mockery::mock(LifetimeGenerator::class);

        $cacheMock = Mockery::mock(CacheInterface::class);
        $cacheMock->shouldReceive('get')->with('keyValue')->andReturn($clientResponse)->once();

        $cachingClient = new CachingClient($clientMock, $cacheMock, $keyGeneratorMock, $lifetimeGeneratorMock);
        $result = $cachingClient->getUnauthenticated('pathValue', ['k' => 'v'], [200, 201]);

        $this->assertEquals($clientResponse, $result);
    }

    public function testGetUnauthenticatedCachesAndReturnsItem()
    {
        $clientResponse = new ClientResponse(
            ['metaKey' => 'metaValue'],
            ['dataKey' => 'dataValue']
        );

        $clientMock = Mockery::mock(ClientInterface::class);
        $clientMock
            ->shouldReceive('getUnauthenticated')
            ->with('pathValue', ['k' => 'v'], [200, 201])
            ->andReturn($clientResponse)
            ->once();

        $keyGeneratorMock = Mockery::mock(KeyGenerator::class);
        $keyGeneratorMock
            ->shouldReceive('generateKey')
            ->with('getUnauthenticated', 'pathValue', ['k' => 'v'], [200, 201])
            ->andReturn('keyValue')
            ->atLeast()
            ->once();

        $lifetimeGeneratorMock = Mockery::mock(LifetimeGenerator::class);
        $lifetimeGeneratorMock->shouldReceive('generateLifetimeSeconds')->andReturn(10)->atLeast()->once();

        $cacheMock = Mockery::mock(CacheInterface::class);
        $cacheMock->shouldReceive('get')->with('keyValue')->andReturn(null)->once();
        $cacheMock->shouldReceive('set')->with('keyValue', $clientResponse, 10)->once();

        $cachingClient = new CachingClient($clientMock, $cacheMock, $keyGeneratorMock, $lifetimeGeneratorMock);
        $result = $cachingClient->getUnauthenticated('pathValue', ['k' => 'v'], [200, 201]);

        $this->assertEquals($clientResponse, $result);
    }

    public function testPostDoesNotInteractWithCache()
    {
        $clientResponse = new ClientResponse(
            ['metaKey' => 'metaValue'],
            ['dataKey' => 'dataValue']
        );

        $clientMock = Mockery::mock(ClientInterface::class);
        $clientMock
            ->shouldReceive('post')
            ->with('pathValue', 'bodyValue', [200, 201])
            ->andReturn($clientResponse)
            ->once();

        $cacheMock = Mockery::mock(CacheInterface::class);
        $keyGeneratorMock = Mockery::mock(KeyGenerator::class);
        $lifetimeGeneratorMock = Mockery::mock(LifetimeGenerator::class);

        $cachingClient = new CachingClient($clientMock, $cacheMock, $keyGeneratorMock, $lifetimeGeneratorMock);
        $result = $cachingClient->post('pathValue', 'bodyValue', [200, 201]);

        $this->assertEquals($clientResponse, $result);
    }

    public function testPostUnauthenticatedDoesNotInteractWithCache()
    {
        $clientResponse = new ClientResponse(
            ['metaKey' => 'metaValue'],
            ['dataKey' => 'dataValue']
        );

        $clientMock = Mockery::mock(ClientInterface::class);
        $clientMock
            ->shouldReceive('postUnauthenticated')
            ->with('pathValue', 'bodyValue', [200, 201])
            ->andReturn($clientResponse)
            ->once();

        $cacheMock = Mockery::mock(CacheInterface::class);
        $keyGeneratorMock = Mockery::mock(KeyGenerator::class);
        $lifetimeGeneratorMock = Mockery::mock(LifetimeGenerator::class);

        $cachingClient = new CachingClient($clientMock, $cacheMock, $keyGeneratorMock, $lifetimeGeneratorMock);
        $result = $cachingClient->postUnauthenticated('pathValue', 'bodyValue', [200, 201]);

        $this->assertEquals($clientResponse, $result);
    }

    public function testPatchDoesNotInteractWithCache()
    {
        $clientResponse = new ClientResponse(
            ['metaKey' => 'metaValue'],
            ['dataKey' => 'dataValue']
        );

        $clientMock = Mockery::mock(ClientInterface::class);
        $clientMock
            ->shouldReceive('patch')
            ->with('pathValue', 'bodyValue', [200, 201])
            ->andReturn($clientResponse)
            ->once();

        $cacheMock = Mockery::mock(CacheInterface::class);
        $keyGeneratorMock = Mockery::mock(KeyGenerator::class);
        $lifetimeGeneratorMock = Mockery::mock(LifetimeGenerator::class);

        $cachingClient = new CachingClient($clientMock, $cacheMock, $keyGeneratorMock, $lifetimeGeneratorMock);
        $result = $cachingClient->patch('pathValue', 'bodyValue', [200, 201]);

        $this->assertEquals($clientResponse, $result);
    }
}
