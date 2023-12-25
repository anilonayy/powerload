<?php

namespace App\Http\Middleware;

use App\Models\RequestLogger as RequestLoggerModel;
use Closure;
use Illuminate\Support\Facades\Log;

class RequestLogger
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        if(!$request->has('_logged')) {
            $request->merge(['_logged' => true]);

            $request->method() !== 'OPTIONS' && RequestLoggerModel::create([
                'path' => $request->path(),
                'method' => $request->method(),
                'request_body' => json_encode($request->all()),
                'response_body' => json_encode($response->getContent()),
                'status_code' => $response->getStatusCode(),
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'user_id' => $request->user() ? $request->user()->id : null
        ]);
        }



        return $response;
    }
}
