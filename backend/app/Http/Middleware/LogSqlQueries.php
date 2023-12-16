<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LogSqlQueries
{
    public function handle($request, Closure $next)
    {
        DB::listen(function ($query) {
            Log::info('SQL Query', [
                'query' => $query->sql,
                'bindings' => $query->bindings,
                'time' => $query->time,
            ]);
        });

        return $next($request);
    }
}
