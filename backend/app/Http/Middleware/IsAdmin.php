<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->user()?->role_slug !== 'adm') {
            return response()->json(['message' => 'Acesso não autorizado'], 403);
        }

        if (auth()->id() == $request->route('id')) {
            return response()->json(['message' => 'Você não pode excluir a si mesmo.'], 403);
        }

        return $next($request);
    }
}
