<?php

namespace App\Http\Middleware;

use App\Models\RequestLogger as RequestLoggerModel;
use Closure;
use Illuminate\Http\Request;

class RequestLogger
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $response = $next($request);

        if (!$request->has('_logged_REQUEST_INFO') && $request->method() !== 'OPTIONS') {
            $request->merge(['_logged_REQUEST_INFO' => true]);

            RequestLoggerModel::create([
                'path' => $request->path(),
                'method' => $request->method(),
                'action' => request()->route()->getActionName() ?? 'Closure',
                'request_body' => json_encode($request->except(['_logged_REQUEST_INFO', '_logged_SQL_QUERIES'])),
                'status_code' => $response->getStatusCode(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'user_id' => $request->user() ? $request->user()->id : null,
                'duration' => floatval(number_format(microtime(true) - LARAVEL_START, 4)),
                'created_at' => time()
            ]);
        }

        return $response;
    }
}
