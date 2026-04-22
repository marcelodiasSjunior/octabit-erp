<x-layouts.app title="Oportunidades" header="Oportunidades">
    <div class="card">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-sm font-semibold text-slate-200">Pipeline Comercial</h2>
            <a href="{{ route('deals.create') }}" class="btn-primary">Nova Oportunidade</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="text-left text-slate-400 border-b border-bg-border">
                        <th class="py-2 pr-4">Titulo</th>
                        <th class="py-2 pr-4">Cliente</th>
                        <th class="py-2 pr-4">Etapa</th>
                        <th class="py-2 pr-4">Status</th>
                        <th class="py-2 pr-4">Valor</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($deals as $deal)
                        <tr class="border-b border-bg-border/50">
                            <td class="py-2 pr-4">
                                <a class="text-octa-400 hover:text-octa-300" href="{{ route('deals.show', $deal) }}">
                                    {{ $deal->title }}
                                </a>
                            </td>
                            <td class="py-2 pr-4">{{ $deal->client->display_name }}</td>
                            <td class="py-2 pr-4">{{ $deal->stage->name }}</td>
                            <td class="py-2 pr-4">{{ $deal->status->label() }}</td>
                            <td class="py-2 pr-4">R$ {{ number_format((float) $deal->value, 2, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-6 text-slate-400">Nenhuma oportunidade cadastrada.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $deals->links() }}
        </div>
    </div>
</x-layouts.app>
