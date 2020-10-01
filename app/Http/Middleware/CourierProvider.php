<?php

namespace App\Http\Middleware;

use Closure;

class CourierProvider
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
        config(['auth.guards.api.provider' => 'couriers']);
        return $next($request);
    }
}
