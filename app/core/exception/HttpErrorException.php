<?php

namespace app\core\exception;

use Throwable;

class HttpErrorException extends \Exception
{
    /**
     * @var int
     */
    private $httpStatusCode;

    /**
     * HttpErrorException constructor
     *
     * @param int $httpStatus
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct(int $httpStatus, string $message = "", int $code = 0, Throwable $previous = null)
    {
        $this->httpStatusCode = $httpStatus;
        parent::__construct($message, $code, $previous);
    }

    /**
     * @return int
     */
    public function getHttpStatusCode()
    {
        return $this->httpStatusCode;
    }
}