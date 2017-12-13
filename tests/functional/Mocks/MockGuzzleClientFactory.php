<?php

namespace DCG\Cinema\Tests\Functional\Mocks;

use DCG\Cinema\Model\UserToken;
use DCG\Cinema\Request\GuzzleClientFactoryInterface;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface as GuzzleClientInterface;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;

/**
 * Class MockGuzzleClientFactory provides mock guzzle clients.
 * The same client object is returned each time to allow for a chain of requests to be passed in the constructor.
 */
class MockGuzzleClientFactory implements GuzzleClientFactoryInterface
{
    private $client;
    private $history;

    /**
     * @param MockHandler $mockHandler
     */
    public function __construct(MockHandler $mockHandler)
    {
        $this->history = [];
        $handler = HandlerStack::create($mockHandler);
        $handler->push(Middleware::history($this->history));
        $this->client = new Client(['handler' => $handler]);
    }

    /**
     * @param UserToken $userToken
     * @return GuzzleClientInterface
     */
    public function create($userToken)
    {
        return $this->client;
    }

    /**
     * @return GuzzleClientInterface
     */
    public function createUnauthenticated()
    {
        return $this->client;
    }

    /**
     * @return array the request history.
     */
    public function getHistory()
    {
        return $this->history;
    }
}
