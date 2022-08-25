<?php

namespace App\Utilities;

use Exception;
use Illuminate\Support\Facades\Log;

class LogErrors
{
    public static function log(Exception $err)
    {
        Log::error($err->getMessage(), ['file' => $err->getLine(), 'line' => $err->getLine(), 'trace' => $err->getTraceAsString()]);
    }
}
