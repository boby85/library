<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle($request, Closure $next, $guard = null)
    {
        if (Auth::guard($guard)->check()) {
            
            $role = Auth::user()->role;
            switch($role) {
                case '1':
                    return redirect('/admin');
                    break;
                case '2':
                    return redirect('/books');
                    break;
                case '3':
                    return redirect('/home');
                    break;
                default:
                    return redirect('/login');
                    break;
            }
        }

        return $next($request);
    }
}
