<?php

namespace DCG\Cinema;

use DCG\Cinema\ActiveUserToken\ActiveUserTokenPersister;
use DCG\Cinema\ActiveUserToken\ActiveUserTokenProvider;
use DCG\Cinema\Api\Chain\ChainFactory;
use DCG\Cinema\Api\Chain\ChainsProvider;
use DCG\Cinema\Api\Cinema\CinemaFactory;
use DCG\Cinema\Api\Cinema\CinemasProvider;
use DCG\Cinema\Api\Order\OrderCompleter;
use DCG\Cinema\Api\Order\OrderCompletionResponseFactory;
use DCG\Cinema\Api\Order\OrderCreationResponseFactory;
use DCG\Cinema\Api\Order\OrderCreator;
use DCG\Cinema\Api\Order\OrderFactory;
use DCG\Cinema\Api\Order\OrderItemFactory;
use DCG\Cinema\Api\Order\OrderProvider;
use DCG\Cinema\Api\Order\OrdersProvider;
use DCG\Cinema\Api\TermsConditions\TermsConditionsFactory;
use DCG\Cinema\Api\TermsConditions\TermsConditionsProvider;
use DCG\Cinema\Api\TicketType\TicketTypeFactory;
use DCG\Cinema\Api\TicketType\TicketTypesProvider;
use DCG\Cinema\Api\User\UserCreator;
use DCG\Cinema\Api\User\UserFactory;
use DCG\Cinema\Api\User\UserProvider;
use DCG\Cinema\Api\UserToken\UserTokenFactory;
use DCG\Cinema\Api\UserToken\UserTokenProvider;
use DCG\Cinema\Cache\CacheInterface;
use DCG\Cinema\Request\Cache\KeyGenerator;
use DCG\Cinema\Request\Cache\LifetimeGenerator;
use DCG\Cinema\Request\Client\AuthenticatedClient;
use DCG\Cinema\Request\Client\CachingClient;
use DCG\Cinema\Request\Client\UnauthenticatedClient;
use DCG\Cinema\Request\Guzzle\GuzzleClientFactory;
use DCG\Cinema\Request\Guzzle\GuzzleClientFactoryInterface;
use DCG\Cinema\Request\RequestSender;
use DCG\Cinema\Validator\ClientResponseDataFieldValidator;
use DCG\Cinema\Session\SessionInterface;

class Di
{
    private static $singleton;

    private $activeUserTokenPersister;
    private $activeUserTokenProvider;
    private $chainsProvider;
    private $cinemasProvider;
    private $orderCompleter;
    private $orderCreator;
    private $orderProvider;
    private $ordersProvider;
    private $termsConditionsProvider;
    private $ticketTypesProvider;
    private $userCreator;
    private $userProvider;
    private $userTokenProvider;

    /**
     * @param SessionInterface $session
     * @param CacheInterface $cache
     * @param string $apiHost
     * @param string $apiClientToken
     * @param int $requestCacheLifetimeMinSeconds
     * @param int $requestCacheLifetimeMaxSeconds
     * @return Di
     */
    public static function build(
        SessionInterface $session,
        CacheInterface $cache,
        $apiHost,
        $apiClientToken,
        $requestCacheLifetimeMinSeconds,
        $requestCacheLifetimeMaxSeconds
    ) {
        if (self::$singleton === null) {
            $guzzleClientFactory = new GuzzleClientFactory($apiHost, $apiClientToken);
            self::$singleton = new Di(
                $session,
                $cache,
                $guzzleClientFactory,
                $requestCacheLifetimeMinSeconds,
                $requestCacheLifetimeMaxSeconds
            );
        }
        return self::$singleton;
    }

    protected function __construct(
        SessionInterface $session,
        CacheInterface $cache,
        GuzzleClientFactoryInterface $guzzleClientFactory,
        $requestCacheLifetimeMinSeconds,
        $requestCacheLifetimeMaxSeconds
    ) {
        $activeUserTokenProvider = new ActiveUserTokenProvider($session);
        $requestSender = new RequestSender();
        $authenticatedClient = new AuthenticatedClient($guzzleClientFactory, $activeUserTokenProvider, $requestSender);
        $unauthenticatedClient = new UnauthenticatedClient($guzzleClientFactory, $requestSender);
        $cachingAuthenticatedClient = new CachingClient(
            $authenticatedClient,
            $cache,
            new KeyGenerator(),
            new LifetimeGenerator($requestCacheLifetimeMinSeconds, $requestCacheLifetimeMaxSeconds)
        );

        $clientResponseDataFieldValidator = new ClientResponseDataFieldValidator();

        $chainFactory = new ChainFactory($clientResponseDataFieldValidator);
        $cinemaFactory = new CinemaFactory($clientResponseDataFieldValidator);
        $orderItemFactory = new OrderItemFactory($clientResponseDataFieldValidator);
        $orderFactory = new OrderFactory($clientResponseDataFieldValidator, $orderItemFactory);
        $orderCompletionResponseFactory = new OrderCompletionResponseFactory($clientResponseDataFieldValidator);
        $orderCreationResponseFactory = new OrderCreationResponseFactory($clientResponseDataFieldValidator);
        $termsConditionsFactory = new TermsConditionsFactory($clientResponseDataFieldValidator);
        $ticketTypeFactory = new TicketTypeFactory($clientResponseDataFieldValidator);
        $userFactory = new UserFactory($clientResponseDataFieldValidator);
        $userTokenFactory = new UserTokenFactory($clientResponseDataFieldValidator);

        $this->activeUserTokenPersister = new ActiveUserTokenPersister($session);
        $this->activeUserTokenProvider = $activeUserTokenProvider;

        // Authenticated
        $this->orderCompleter = new OrderCompleter($authenticatedClient, $orderCompletionResponseFactory);
        $this->orderCreator = new OrderCreator($authenticatedClient, $orderCreationResponseFactory);
        $this->orderProvider = new OrderProvider($authenticatedClient, $orderFactory);
        $this->ordersProvider = new OrdersProvider($authenticatedClient, $orderFactory);

        // Unauthenticated
        $this->userCreator = new UserCreator($unauthenticatedClient, $userFactory);
        $this->userProvider = new UserProvider($unauthenticatedClient, $userFactory);
        $this->userTokenProvider = new UserTokenProvider($unauthenticatedClient, $userTokenFactory);

        // Authenticated and cached
        $this->chainsProvider = new ChainsProvider($cachingAuthenticatedClient, $chainFactory);
        $this->cinemasProvider = new CinemasProvider($cachingAuthenticatedClient, $cinemaFactory);
        $this->termsConditionsProvider = new TermsConditionsProvider(
            $cachingAuthenticatedClient,
            $termsConditionsFactory
        );
        $this->ticketTypesProvider = new TicketTypesProvider($cachingAuthenticatedClient, $ticketTypeFactory);
    }

    /**
     * @return ActiveUserTokenPersister
     */
    public function getActiveUserTokenPersister()
    {
        return $this->activeUserTokenPersister;
    }

    /**
     * @return ActiveUserTokenProvider
     */
    public function getActiveUserTokenProvider()
    {
        return $this->activeUserTokenProvider;
    }

    /**
     * @return ChainsProvider
     */
    public function getChainsProvider()
    {
        return $this->chainsProvider;
    }

    /**
     * @return CinemasProvider
     */
    public function getCinemasProvider()
    {
        return $this->cinemasProvider;
    }

    /**
     * @return OrderCompleter
     */
    public function getOrderCompleter()
    {
        return $this->orderCompleter;
    }

    /**
     * @return OrderCreator
     */
    public function getOrderCreator()
    {
        return $this->orderCreator;
    }

    /**
     * @return OrderProvider
     */
    public function getOrderProvider()
    {
        return $this->orderProvider;
    }

    /**
     * @return OrdersProvider
     */
    public function getOrdersProvider()
    {
        return $this->ordersProvider;
    }

    /**
     * @return TermsConditionsProvider
     */
    public function getTermsConditionsProvider()
    {
        return $this->termsConditionsProvider;
    }

    /**
     * @return TicketTypesProvider
     */
    public function getTicketTypesProvider()
    {
        return $this->ticketTypesProvider;
    }

    /**
     * @return UserCreator
     */
    public function getUserCreator()
    {
        return $this->userCreator;
    }

    /**
     * @return UserProvider
     */
    public function getUserProvider()
    {
        return $this->userProvider;
    }

    /**
     * @return UserTokenProvider
     */
    public function getUserTokenProvider()
    {
        return $this->userTokenProvider;
    }
}
