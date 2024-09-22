<?php

namespace App\Http\Middleware;

use Closure;
use AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;

class IsPenulis
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->level == "Penulis") {
            return $next($request);
        }

        return redirect('/operator/dashboard');
    }
}
