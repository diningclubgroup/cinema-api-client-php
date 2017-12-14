<?php

namespace DCG\Cinema\Exception;

use Throwable;

class UnexpectedStatusCodeException extends \RuntimeException
{
    /**
     * @param int $code
     * @param string|null $message
     * @param Throwable|null $previous
     */
    public function __construct(int $code, string $message = null, \Throwable $previous = null)
    {
        if ($message === null) {
            $message = "Unexpected response status code: {$code}";
        }

        parent::__construct($message, $code, $previous);
    }
}
