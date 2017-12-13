<?php

namespace DCG\Cinema\Tests\Functional\Api\TicketType;

use DCG\Cinema\Exception\UnexpectedResponseContentException;
use DCG\Cinema\Exception\UnexpectedStatusCodeException;
use DCG\Cinema\Exception\UserNotAuthenticatedException;
use DCG\Cinema\Tests\Functional\Mocks\MockCache;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\Psr7\Response;
use PHPUnit\Framework\TestCase;
use DCG\Cinema\Tests\Functional\Mocks\MockGuzzleClientDi;
use DCG\Cinema\Tests\Functional\Mocks\MockGuzzleClientFactory;
use DCG\Cinema\Tests\Functional\Mocks\MockSession;

class TicketTypesProviderTest extends TestCase
{
    public function testItReturnsTheExpectedTicketTypes()
    {
        $mockGuzzleClientFactory = new MockGuzzleClientFactory(
            new MockHandler([
                new Response(200, [], json_encode([
                    'data' => [
                        [
                            'id' => 'idValue0',
                            'vendor_id' => 'vendorIdValue0',
                            'chain_id' => 'chainIdValue0',
                            'location_id' => 'locationIdValue0',
                            'price' => 1.1,
                            'currency' => 'currencyValue0',
                            'conditions_of_use' => 'conditionsValue0',
                            'properties' => [
                                'propertyValue00',
                                'propertyValue01',
                            ],
                            'has_low_quantity' => true,
                        ],
                        [
                            'id' => 'idValue1',
                            'vendor_id' => 'vendorIdValue1',
                            'chain_id' => 'chainIdValue1',
                            'location_id' => 'locationIdValue1',
                            'price' => 2.2,
                            'currency' => 'currencyValue1',
                            'conditions_of_use' => 'conditionsValue1',
                            'properties' => [
                                'propertyValue10',
                            ],
                            'has_low_quantity' => false,
                        ],
                    ],
                ]))
            ])
        );

        $di = MockGuzzleClientDi::buildMockDi(MockSession::createWithActiveUserToken(), $mockGuzzleClientFactory);

        $ticketTypes = $di->getTicketTypesProvider()->getTicketTypes('chainIdValue');

        $this->assertCount(2, $ticketTypes);

        $this->assertEquals('idValue0', $ticketTypes[0]->getId());
        $this->assertEquals('vendorIdValue0', $ticketTypes[0]->getVendorId());
        $this->assertEquals('chainIdValue0', $ticketTypes[0]->getChainId());
        $this->assertEquals('locationIdValue0', $ticketTypes[0]->getLocationId());
        $this->assertEquals(1.1, $ticketTypes[0]->getPrice());
        $this->assertEquals('currencyValue0', $ticketTypes[0]->getCurrency());
        $this->assertEquals('conditionsValue0', $ticketTypes[0]->getConditionsOfUse());
        $this->assertEquals(['propertyValue00', 'propertyValue01'], $ticketTypes[0]->getProperties());
        $this->assertEquals(true, $ticketTypes[0]->getHasLowQuantity());

        $this->assertEquals('idValue1', $ticketTypes[1]->getId());
        $this->assertEquals('vendorIdValue1', $ticketTypes[1]->getVendorId());
        $this->assertEquals('chainIdValue1', $ticketTypes[1]->getChainId());
        $this->assertEquals('locationIdValue1', $ticketTypes[1]->getLocationId());
        $this->assertEquals(2.2, $ticketTypes[1]->getPrice());
        $this->assertEquals('currencyValue1', $ticketTypes[1]->getCurrency());
        $this->assertEquals('conditionsValue1', $ticketTypes[1]->getConditionsOfUse());
        $this->assertEquals(['propertyValue10'], $ticketTypes[1]->getProperties());
        $this->assertEquals(false, $ticketTypes[1]->getHasLowQuantity());

        $requestHistory = $mockGuzzleClientFactory->getHistory();
        $this->assertCount(1, $requestHistory);
        $this->assertEquals('GET', $requestHistory[0]['request']->getMethod());
        $this->assertEquals('chains/chainIdValue/ticket-types', (string)$requestHistory[0]['request']->getUri());
    }

    public function testItInteractsWithCache()
    {
        $mockCache = new MockCache();

        $testExpectations = function ($ticketTypes) {
            $this->assertCount(1, $ticketTypes);
            $this->assertEquals('idValue0', $ticketTypes[0]->getId());
            $this->assertEquals('vendorIdValue0', $ticketTypes[0]->getVendorId());
            $this->assertEquals('chainIdValue0', $ticketTypes[0]->getChainId());
            $this->assertEquals('locationIdValue0', $ticketTypes[0]->getLocationId());
            $this->assertEquals(1.1, $ticketTypes[0]->getPrice());
            $this->assertEquals('currencyValue0', $ticketTypes[0]->getCurrency());
            $this->assertEquals('conditionsValue0', $ticketTypes[0]->getConditionsOfUse());
            $this->assertEquals(['propertyValue00', 'propertyValue01'], $ticketTypes[0]->getProperties());
            $this->assertEquals(true, $ticketTypes[0]->getHasLowQuantity());
        };

        // First request should hit the API
        $mockGuzzleClientFactory = new MockGuzzleClientFactory(
            new MockHandler([
                new Response(200, [], json_encode([
                    'data' => [
                        [
                            'id' => 'idValue0',
                            'vendor_id' => 'vendorIdValue0',
                            'chain_id' => 'chainIdValue0',
                            'location_id' => 'locationIdValue0',
                            'price' => 1.1,
                            'currency' => 'currencyValue0',
                            'conditions_of_use' => 'conditionsValue0',
                            'properties' => [
                                'propertyValue00',
                                'propertyValue01',
                            ],
                            'has_low_quantity' => true,
                        ],
                    ],
                ]))
            ])
        );

        $di = MockGuzzleClientDi::buildMockDi(
            MockSession::createWithActiveUserToken(),
            $mockGuzzleClientFactory,
            $mockCache
        );

        $ticketTypes = $di->getTicketTypesProvider()->getTicketTypes('chainId');
        $testExpectations($ticketTypes);

        // Second request should not hit the API but fetch from cache
        $mockGuzzleClientFactory = new MockGuzzleClientFactory(new MockHandler([]));

        $di = MockGuzzleClientDi::buildMockDi(
            MockSession::createWithActiveUserToken(),
            $mockGuzzleClientFactory,
            $mockCache
        );

        $ticketTypes = $di->getTicketTypesProvider()->getTicketTypes('chainId');
        $testExpectations($ticketTypes);
    }

    public function testItThrowsOnUnexpectedStatusCode()
    {
        $di = MockGuzzleClientDi::buildMockDi(
            MockSession::createWithActiveUserToken(),
            new MockGuzzleClientFactory(new MockHandler([new Response(201)]))
        );

        $this->expectException(UnexpectedStatusCodeException::class);

        $di->getTicketTypesProvider()->getTicketTypes('chainId');
    }

    public function testItThrowsOnUnexpectedResponseContent()
    {
        $di = MockGuzzleClientDi::buildMockDi(
            MockSession::createWithActiveUserToken(),
            new MockGuzzleClientFactory(
                new MockHandler([
                    new Response(200, [], json_encode([
                        'data' => [
                            [
                                'id' => 'idValue0',
                            ],
                        ],
                    ]))
                ])
            )
        );

        $this->expectException(UnexpectedResponseContentException::class);

        $di->getTicketTypesProvider()->getTicketTypes('chainId');
    }

    public function testItThrowsOnInactiveUserToken()
    {
        $di = MockGuzzleClientDi::buildMockDi(
            MockSession::createWithInactiveUserToken(),
            new MockGuzzleClientFactory(new MockHandler([]))
        );

        $this->expectException(UserNotAuthenticatedException::class);

        $di->getTicketTypesProvider()->getTicketTypes('chainId');
    }

    public function testItThrowsOnMissingUserToken()
    {
        $di = MockGuzzleClientDi::buildMockDi(
            MockSession::createWithNoUserToken(),
            new MockGuzzleClientFactory(new MockHandler([]))
        );

        $this->expectException(UserNotAuthenticatedException::class);

        $di->getTicketTypesProvider()->getTicketTypes('chainId');
    }
}
