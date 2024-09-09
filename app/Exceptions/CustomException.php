<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

class CustomException extends Exception
{
    public function __construct($message = 'An unexpected error occurred.')
    {
        parent::__construct($message);
    }

    public function render(): Response
    {
        $status = 400;

        return response(['message' => $this->message], $status);
    }
}
