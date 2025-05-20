<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckRole
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (!Session::has('usuario') || Session::get('rol') !== $role) {
            return redirect('/login');
        }

        return $next($request);
    }
}