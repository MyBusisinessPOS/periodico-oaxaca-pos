<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class Unsubscribed
{
    /**
     * Handle an incoming request.
     *
     * Verficamos si el usuario tiene una subscripcion activa
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (optional($request->user())->hasActiveSubscription()) {
            return redirect()->route('home');
        }
        return $next($request);
    }
}
