<?php

namespace App\Http\Middleware;

use Closure;

class TenderMiddleware
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
        if (auth()->user()->roles()->first()->name == 'tender')
        {
            return $next($request);
        }
        return redirect()->guest('/');
    }
}
