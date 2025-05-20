<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        // Si ya hay sesión iniciada
        if (Session::has('usuario')) {
            $rol = Session::get('rol');
            
            // Redireccionar según el rol
            switch ($rol) {
                case 'admin':
                    return redirect()->route('admin.dashboard');
                case 'empleado':
                    return redirect()->route('empleado.dashboard');
                case 'cliente':
                    return redirect()->route('cliente.dashboard');
                default:
                    return redirect('/');
            }
        }

        return $next($request);
    }
}