<?php

namespace App\Exceptions;

use Exception;

class DataNotFoundException extends Exception
{
    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }
}
