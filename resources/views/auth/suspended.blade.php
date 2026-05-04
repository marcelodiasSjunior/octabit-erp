<!DOCTYPE html>
<html lang="pt-BR" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acesso Suspenso — OctaBit ERP</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-bg-primary min-h-screen flex items-center justify-center p-6 text-slate-200">
    <div class="max-w-md w-full bg-bg-secondary border border-bg-border rounded-xl p-8 shadow-glow-sm text-center">
        <div class="w-16 h-16 bg-red-500/10 text-red-500 rounded-full flex items-center justify-center mx-auto mb-6">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
            </svg>
        </div>
        
        <h1 class="text-2xl font-bold mb-2">Acesso Suspenso</h1>
        <p class="text-slate-400 mb-8">
            Sentimos muito, mas o acesso da sua empresa ao sistema foi temporariamente suspenso.
            Por favor, entre em contato com o administrador financeiro ou com o suporte da OctaBit para regularizar sua situação.
        </p>

        <div class="space-y-3">
            <a href="mailto:suporte@octabit.tech" class="btn-primary w-full flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Falar com Suporte
            </a>
            
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="btn-secondary w-full">Voltar para o Login</button>
            </form>
        </div>
        
        <div class="mt-8 pt-6 border-t border-bg-border text-xs text-slate-500">
            &copy; {{ date('Y') }} OctaBit Tech. Todos os direitos reservados.
        </div>
    </div>
</body>
</html>
