<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
public function handle(Request $request, Closure $next, string $role): Response
{
    // Verifica se o utilizador não está autenticado ou se a role não coincide
    if (! $request->user() || $request->user()->role !== $role) {
        // Redireciona para a página de login ou retorna um erro 403
        abort(403, 'Acesso negado. Você não tem permissão para aceder a esta funcionalidade.');
    }

    return $next($request);
}}
