<?php

namespace Tests\Functional\Mocks;

use DCG\Cinema\ActiveUserToken\ActiveUserToken;
use DCG\Cinema\Model\UserToken;
use DCG\Cinema\Session\SessionInterface;

class MockSession implements SessionInterface
{
    const USER_TOKEN_VALUE = 'userTokenValue';

    private $items;

    /**
     * @param array $items optional key-value pairs to represent the initial cache content.
     * @return MockSession
     */
    public static function createWithActiveUserToken(array $items = [])
    {
        return new MockSession(
            new UserToken(self::USER_TOKEN_VALUE, time() + 20),
            $items
        );
    }

    /**
     * @param array $items optional key-value pairs to represent the initial cache content.
     * @return MockSession
     */
    public static function createWithInactiveUserToken(array $items = [])
    {
        return new MockSession(
            new UserToken(self::USER_TOKEN_VALUE, time() - 20),
            $items
        );
    }

    /**
     * @param array $items optional key-value pairs to represent the initial cache content.
     * @return MockSession
     */
    public static function createWithNoUserToken(array $items = [])
    {
        return new MockSession(null, $items);
    }


    /**
     * @param UserToken|null $userToken
     * @param array $items optional key-value pairs to represent the initial cache content.
     */
    private function __construct(UserToken $userToken = null, array $items = [])
    {
        $this->items = $items;

        if ($userToken !== null) {
            $this->items[ActiveUserToken::SESSION_KEY_NAME] = $userToken;
        }
    }

    /**
     * Gets the value of the specified key from the session.
     * Returns null if the key does not exist.
     *
     * @param string $key
     * @return mixed
     */
    public function get($key)
    {
        if (array_key_exists($key, $this->items)) {
            return $this->items[$key];
        }
        return null;
    }

    /**
     * Sets the specified value in the session using the specified key.
     *
     * @param string $key
     * @param mixed $value
     */
    public function set($key, $value)
    {
        $this->items[$key] = $value;
    }
}
