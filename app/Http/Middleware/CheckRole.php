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
    if (!Auth::check() || Auth::user()->role !== $role) {
        abort(403, 'Ação não autorizada.');
    }

    return $next($request);
}}
