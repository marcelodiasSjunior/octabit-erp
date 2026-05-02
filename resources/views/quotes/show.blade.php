<x-layouts.app title="Orçamento {{ $quote->formatted_number }}" header="Orçamentos / {{ $quote->formatted_number }}">

    {{-- Flash --}}
    @if(session('success'))
        <div class="mb-4 px-4 py-3 rounded-lg bg-green-500/10 border border-green-500/30 text-green-400 text-sm">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-4 px-4 py-3 rounded-lg bg-red-500/10 border border-red-500/30 text-red-400 text-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="max-w-4xl space-y-4">

        {{-- Header --}}
        <div class="card flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
            <div>
                <div class="flex items-center gap-3 mb-2">
                    <h1 class="text-xl font-bold text-slate-100">Orçamento {{ $quote->formatted_number }}</h1>
                    <x-status-badge :status="$quote->status"/>
                </div>
                <p class="text-sm text-slate-400">
                    Cliente: <span class="text-slate-200 font-medium">{{ $quote->client->name ?? '—' }}</span>
                </p>
                <p class="text-sm text-slate-400">
                    Criado em: <span class="text-slate-300">{{ $quote->created_at->format('d/m/Y H:i') }}</span>
                </p>
                @if($quote->valid_until)
                    <p class="text-sm text-slate-400">
                        Válido até:
                        <span @class(['text-red-400' => $quote->valid_until->isPast() && $quote->status->value !== 'approved', 'text-slate-300' => !$quote->valid_until->isPast() || $quote->status->value === 'approved'])>
                            {{ $quote->valid_until->format('d/m/Y') }}
                        </span>
                    </p>
                @endif
                @if($quote->converted_to_sale_at)
                    <p class="text-sm text-green-400 mt-1">
                        Convertido em {{ $quote->converted_to_sale_at->format('d/m/Y H:i') }}
                    </p>
                @endif
            </div>

            {{-- Actions --}}
            <div class="flex flex-wrap gap-2 shrink-0">
                @if($quote->status->value === 'draft')
                    <a href="{{ route('quotes.edit', $quote->id) }}" class="btn-ghost btn-sm">
                        Editar
                    </a>
                    <form method="POST" action="{{ route('quotes.send', $quote->id) }}">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn-primary btn-sm">Marcar como Enviado</button>
                    </form>
                @endif

                @if($quote->status->value === 'sent')
                    <form method="POST" action="{{ route('quotes.approve', $quote->id) }}">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn-primary btn-sm bg-green-600 hover:bg-green-500">Aprovar</button>
                    </form>
                    <form method="POST" action="{{ route('quotes.reject', $quote->id) }}"
                          x-data @submit.prevent="$dispatch('dialog', { 
                              title: 'Rejeitar Orçamento', 
                              message: 'Deseja realmente marcar o orçamento #{{ $quote->id }} como rejeitado?',
                              type: 'danger',
                              confirmText: 'Sim, rejeitar',
                              onConfirm: () => $el.submit()
                          })">
                        @csrf @method('PATCH')
                        <button type="submit" class="btn-ghost btn-sm text-red-400 hover:text-red-300">Rejeitar</button>
                    </form>
                @endif

                <a href="{{ route('api.quotes.pdf', $quote->id) }}" target="_blank" class="btn-ghost btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                    </svg>
                    PDF
                </a>

                <a href="{{ route('quotes.index') }}" class="btn-ghost btn-sm">← Voltar</a>
            </div>
        </div>

        {{-- Items table --}}
        <div class="card">
            <h2 class="text-base font-semibold text-slate-200 mb-4">Itens do Orçamento</h2>

            <div class="table-wrapper">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Descrição</th>
                            <th class="text-right">Qtd</th>
                            <th class="text-right">Preço unit.</th>
                            <th class="text-right">Desc. %</th>
                            <th class="text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($quote->items as $item)
                            <tr>
                                <td>{{ $item->description }}</td>
                                <td class="text-right font-mono text-sm">{{ number_format($item->quantity, 2, ',', '.') }}</td>
                                <td class="text-right font-mono text-sm">R$ {{ number_format($item->unit_price, 2, ',', '.') }}</td>
                                <td class="text-right font-mono text-sm text-slate-400">
                                    {{ $item->discount > 0 ? number_format($item->discount, 2, ',', '.') . '%' : '—' }}
                                </td>
                                <td class="text-right font-semibold text-octa-300">R$ {{ number_format($item->line_total, 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Totals --}}
            <div class="mt-6 flex flex-col items-end gap-1 text-sm border-t border-bg-border pt-4">
                <div class="flex gap-6 text-slate-400">
                    <span>Subtotal</span>
                    <span class="w-32 text-right">R$ {{ number_format($quote->subtotal, 2, ',', '.') }}</span>
                </div>
                @if($quote->discount_total > 0)
                    <div class="flex gap-6 text-red-400">
                        <span>Descontos</span>
                        <span class="w-32 text-right">- R$ {{ number_format($quote->discount_total, 2, ',', '.') }}</span>
                    </div>
                @endif
                <div class="flex gap-6 text-slate-100 font-bold text-base mt-1">
                    <span>Total</span>
                    <span class="w-32 text-right text-octa-300">R$ {{ number_format($quote->total, 2, ',', '.') }}</span>
                </div>
            </div>
        </div>

    </div>

</x-layouts.app>
