<?php

namespace App\GDPrimitives;

use Cake\Core\Exception\Exception;
use Throwable;

class BadConstructorValueException extends Exception
{

    /**
     * @param string $msg
     */
    public function __construct(string $msg, ?int $code = null, ?Throwable $previous = null)
    {
        parent::__construct($msg, $code, $previous);
    }
}
