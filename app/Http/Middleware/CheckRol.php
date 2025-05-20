<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckRol
{
    public function handle(Request $request, Closure $next, $rol)
    {
        if (!Session::has('rol') || Session::get('rol') !== $rol) {
            return redirect('/login')->with('error', 'No tiene permiso para acceder a esta sección');
        }
        
        return $next($request);
    }
}