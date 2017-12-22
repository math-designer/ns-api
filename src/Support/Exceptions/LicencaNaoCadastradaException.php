<?php

namespace NS\Support\Exceptions;

use Throwable;

class LicencaNaoCadastradaException extends \Exception
{
    public function __construct($message = "", $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}