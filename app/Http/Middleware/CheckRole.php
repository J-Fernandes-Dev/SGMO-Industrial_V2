<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // Se o utilizador não estiver autenticado ou não tiver as habilitações necessárias
        if (!$request->user() || $request->user()->role !== $role) {
            abort(403, 'Acesso não autorizado para o seu perfil.');
        }

        return $next($request);
    }
}
