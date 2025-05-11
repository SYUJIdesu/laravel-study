<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogExceptionHandler
{
    /**
     * @param  \Throwable    $e
     * @param  \Illuminate\Http\Request  $request
     */
    public function __invoke(Throwable $e, Request $request): bool
    {
        Log::error('Unexpected Exception Caught', [
            'message'   => $e->getMessage(),
            'exception' => $e,
            'url'       => $request->fullUrl(),
            'input'     => $request->all(),
        ]);

        return true;
    }
}