<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            switch(Auth::user()->role){
                case 'admin':
                    return redirect('/admin');
                    break;
                case 'pasien':
                    return redirect('/pasien');
                    break;
                case 'dokter':
                    return redirect('/dokter');
                    break;
                default:
                    return redirect('/login');
            }
        }

        return $next($request);
    }
}
