<?php

use Illuminate\Support\Facades\Log;
use App\Models\Tenant\Tenant;

if (!function_exists('success_log')) {
    function success_log(string $message, array $data = [])
    {
        // Log the success message with additional context
        Log::info($message, [
            'user_id' => auth()->id(),
            'tenant'  => Tenant::current()?->id ?? null,
            'api_url' => request()->path(),
            ...$data
        ]);
    }
}

if (!function_exists('error_log')) {
    function error_log(Throwable $th, string $message = 'Error Log')
    {
        // Log the error message with additional context
        Log::error($message . '! ' . $th->getMessage(), [
            'file'    => $th->getFile(),
            'line'    => $th->getLine(),
            'user_id' => auth()->id(),
            'tenant'  => Tenant::current()?->id ?? null,
            'api_url' => request()->path(),
        ]);
    }
}
