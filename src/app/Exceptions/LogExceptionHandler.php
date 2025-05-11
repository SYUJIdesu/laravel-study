<?php

namespace App\Exceptions;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class LogExceptionHandler
{
    public function __invoke(Throwable $e, Request $request): bool
    {
        Log::error('Unexpected Exception Caught', [
            'message' => $e->getMessage(),
            'exception' => $e,
            'url' => $request->fullUrl(),
            'input' => $request->all(),
        ]);

        return true;
    }
}
