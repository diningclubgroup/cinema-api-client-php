<?php

namespace DCG\Cinema\Exception;

use Throwable;

class UserNotAuthenticatedException extends \RuntimeException
{
    /**
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "User is not authenticated", $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
