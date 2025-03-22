<?php

namespace App\Exceptions;

use Exception;

class HandlerError extends Exception
{
    protected $code;
    public function __construct(string $message = "", int $code = 400)
    {
        parent::__construct($message, code: $code);
    }

    public function render($request)
    {
        return response()->json([
            'success' => false,
            'message' => $this->getMessage(),
            'data' => null
        ], $this->getCode());
    }
}
