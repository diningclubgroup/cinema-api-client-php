<?php

namespace DCG\Cinema\Exception;

use Throwable;

class UnexpectedResponseContentException extends \RuntimeException
{
    /**
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(
        string $message = "Unexpected response content",
        int $code = 0,
        \Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
