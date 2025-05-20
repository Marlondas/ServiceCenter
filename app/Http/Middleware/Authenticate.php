<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Authenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Verifica si el usuario ha iniciado sesión
        if (!Session::has('usuario')) {
            // Si hay una solicitud AJAX
            if ($request->ajax() || $request->wantsJson()) {
                return response('Unauthorized.', 401);
            }
            
            // Redirige al login
            return redirect()->route('login.form');
        }

        return $next($request);
    }
}