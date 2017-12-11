<?php

namespace DCG\Cinema\Exception;

use Throwable;

class UnexpectedStatusCodeException extends \RuntimeException
{
    private $statusCode;

    /**
     * @param int $statusCode
     * @param string|null $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($statusCode, $message = null, $code = 0, $previous = null)
    {
        $this->statusCode = $statusCode;

        if ($message === null) {
            $message = "Unexpected response status code: {$statusCode}";
        }

        parent::__construct($message, $code, $previous);
    }

    public function getStatusCode()
    {
        return $this->statusCode;
    }
}
