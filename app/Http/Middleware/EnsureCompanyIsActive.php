<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class EnsureCompanyIsActive
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Ignorar se for a própria rota de suspensão
        if ($request->routeIs('account.suspended')) {
            return $next($request);
        }

        $user = $request->user();

        // 1. Usuários não logados ou Master Global ignoram a trava
        if (!$user || $user->isMasterGlobal()) {
            return $next($request);
        }

        // 2. Verifica o status da empresa vinculada
        $company = $user->company;

        if ($company && $company->status !== 'active') {
            // Se for uma requisição AJAX/JSON
            if ($request->expectsJson()) {
                return response()->json([
                    'message' => 'Sua conta está suspensa. Entre em contato com o suporte.'
                ], 403);
            }

            // Redireciona para uma tela de aviso (precisaremos criar essa rota/view)
            return redirect()->route('account.suspended');
        }

        return $next($request);
    }
}
