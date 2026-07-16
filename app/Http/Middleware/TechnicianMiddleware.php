<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class TechnicianMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param Closure $next
     * @return mixed
     */

    public function handle($request, Closure $next)
    {
        if (auth()->user()->roles()->first()->name == 'assignee')
        {
            return $next($request);
        }
        return redirect()->guest('/');
    }
}
