<x-layouts.app title="Contrato" header="Contratos">

    <div id="show-contract-container" class="max-w-2xl space-y-6">

        @if(session('success'))
            <div id="flash-success" class="px-4 py-3 rounded-lg bg-green-500/10 border border-green-500/30 text-green-400 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div id="show-contract-card" class="card space-y-4">
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-slate-100">
                        Contrato #{{ $contract->id }} —
                        <a id="link-show-client" href="{{ route('clients.show', $contract->client) }}"
                           class="text-octa-400 hover:text-octa-300">{{ $contract->client->name }}</a>
                    </h2>
                    <x-status-badge :status="$contract->status" class="mt-1"/>
                </div>
                <a id="btn-edit-contract" href="{{ route('contracts.edit', $contract) }}" class="btn-ghost btn-sm">Editar</a>
            </div>

            <dl class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <dt class="text-slate-500">Valor</dt>
                    <dd class="text-slate-200 font-semibold">R$ {{ number_format($contract->value, 2, ',', '.') }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500">Início</dt>
                    <dd class="text-slate-200">{{ $contract->start_date->format('d/m/Y') }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500">Término</dt>
                    <dd class="text-slate-200">{{ $contract->end_date?->format('d/m/Y') ?? 'Indeterminado' }}</dd>
                </div>
                @if($contract->notes)
                    <div class="col-span-2">
                        <dt class="text-slate-500">Notas</dt>
                        <dd class="text-slate-300">{{ $contract->notes }}</dd>
                    </div>
                @endif

                @if($contract->file_path)
                    <div class="col-span-2">
                        <dt class="text-slate-500">Arquivo</dt>
                        <dd class="mt-1">
                            <a id="link-download-contract" href="{{ route('contracts.download', $contract->id) }}"
                               class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-bg-input border border-bg-border text-sm text-octa-400 hover:text-octa-300 hover:border-octa-500 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                Baixar arquivo
                            </a>
                        </dd>
                    </div>
                @endif
            </dl>
        </div>

        <a id="btn-back-contracts" href="{{ route('contracts.index') }}" class="btn-ghost">← Voltar</a>
    </div>

</x-layouts.app>
