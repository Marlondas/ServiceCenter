<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Support\Facades\Session;

class VerifyCsrfToken
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [
        // Rutas excluidas de verificación CSRF (si necesitas alguna)
    ];

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Solo verificar en solicitudes POST, PUT, DELETE, PATCH
        if (in_array($request->method(), ['POST', 'PUT', 'DELETE', 'PATCH'])) {
            // Verificar si la ruta está excluida
            foreach ($this->except as $except) {
                if ($request->is($except)) {
                    return $next($request);
                }
            }
            
            // Verificar token CSRF
            if ($request->input('_token') !== Session::token()) {
                throw new TokenMismatchException('CSRF token mismatch.');
            }
        }

        return $next($request);
    }
}