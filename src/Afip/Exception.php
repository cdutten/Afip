<?php

namespace Afip;

use Throwable;

/**
 * Class Exception
 * @package Afip
 */
class Exception extends \Exception
{
    /**
     * Exception constructor.
     * @param string $message
     * @param int $code
     * @param Throwable|null $previous
     */
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct("Afip: {$message}", $code, $previous);
    }
}