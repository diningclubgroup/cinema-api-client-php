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
    public function __construct($message = "Unexpected response content", $code = 0, $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
