<?php

namespace App\Http\Middleware;

use App\Error;
use App\Response;
use Closure;
use Illuminate\Http\Request;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $bearerTokenString = $request->bearerToken();

        if ($bearerTokenString == 'ldn7W6HruQATRf7M') {
            return $next($request);
        }
        return response()->json([], 404, []);
    }
}
