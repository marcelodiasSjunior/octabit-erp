<x-layouts.app title="{{ $service->name }}" header="Serviços">

    <div class="max-w-2xl space-y-6">

        @if(session('success'))
            <div class="px-4 py-3 rounded-lg bg-green-500/10 border border-green-500/30 text-green-400 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="card space-y-4">
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-slate-100">{{ $service->name }}</h2>
                    <span class="badge mt-1">{{ $service->type->label() }}</span>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('services.edit', $service) }}" class="btn-ghost btn-sm">Editar</a>
                </div>
            </div>

            <dl class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <dt class="text-slate-500">Preço Base</dt>
                    <dd class="text-slate-200 font-semibold">R$ {{ number_format($service->base_price, 2, ',', '.') }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500">Taxa de Setup</dt>
                    <dd class="text-slate-200">
                        {{ $service->setup_price ? 'R$ ' . number_format($service->setup_price, 2, ',', '.') : '—' }}
                    </dd>
                </div>
                <div>
                    <dt class="text-slate-500">Status</dt>
                    <dd>
                        @if($service->active)
                            <span class="badge-success">Ativo</span>
                        @else
                            <span class="badge-muted">Inativo</span>
                        @endif
                    </dd>
                </div>
                @if($service->description)
                    <div class="col-span-2">
                        <dt class="text-slate-500">Descrição</dt>
                        <dd class="text-slate-300">{{ $service->description }}</dd>
                    </div>
                @endif
            </dl>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('services.index') }}" class="btn-ghost">← Voltar</a>
        </div>
    </div>

</x-layouts.app>
