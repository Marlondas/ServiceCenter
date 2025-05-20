<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckAuth
{
    public function handle(Request $request, Closure $next)
    {
        if (!Session::has('id_usuario')) {
            return redirect('/login')->with('error', 'Debe iniciar sesión para acceder a esta página');
        }
        
        return $next($request);
    }
}