<?php

namespace App\Utilities;

use Illuminate\Support\Facades\Log;
use Throwable;

class MyLogger
{
    public static function error(Throwable $e)
    {
        Log::error($e->getMessage(), ['file' => $e->getLine(), 'line' => $e->getLine(), 'trace' => $e->getTraceAsString()]);
    }

    public static function info(string $msg)
    {
        Log::info($msg);
    }
}
