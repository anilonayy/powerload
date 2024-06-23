<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class LogSqlQueries
{
    public function handle($request, Closure $next)
    {
        if (!$request->has('_logged_SQL_QUERIES')) {
            $request->merge(['_logged_SQL_QUERIES' => true]);

            DB::listen(function ($query) {
                Log::info('SQL Query', [
                    'query' => $query->sql,
                    'bindings' => $query->bindings,
                    'time' => $query->time,
                ]);
            });
        }

        return $next($request);
    }
}
