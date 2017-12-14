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
    public function __construct(
        string $message = "User is not authenticated",
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
