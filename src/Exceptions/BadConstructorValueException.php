<?php

namespace App\Exceptions;

use Cake\Core\Exception\Exception;
use Throwable;

class BadConstructorValueException extends Exception
{

    /**
     * @param string $msg
     * @param int|null $code
     * @param Throwable|null $previous
     */
    public function __construct(string $msg, ?int $code = null, ?Throwable $previous = null)
    {
        parent::__construct($msg, $code, $previous);
    }
}
