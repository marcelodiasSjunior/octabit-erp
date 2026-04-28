<x-layouts.app title="Gerenciar Tags" header="Configurações / Tags">

    <div class="max-w-4xl">
        <div class="flex justify-between items-center mb-6">
            <div>
                <h2 class="text-base font-semibold text-slate-200">Tags de CRM</h2>
                <p class="text-xs text-slate-500 mt-1">Categorize seus leads e clientes para melhor organização.</p>
            </div>
            <a href="{{ route('tags.create') }}" class="btn-primary btn-sm">Nova Tag</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($tags as $tag)
                <div class="card p-4 flex items-center justify-between group">
                    <div class="flex items-center gap-3">
                        <div class="w-3 h-3 rounded-full" style="background-color: {{ $tag->color }};"></div>
                        <div>
                            <p class="text-sm font-medium text-slate-200">{{ $tag->name }}</p>
                            @if($tag->description)
                                <p class="text-[10px] text-slate-500">{{ $tag->description }}</p>
                            @endif
                        </div>
                    </div>
                    <form action="{{ route('tags.destroy', $tag) }}" method="POST" x-data @submit.prevent="if(confirm('Remover esta tag?')) $el.submit()">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-slate-600 hover:text-red-400 opacity-0 group-hover:opacity-100 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                        </button>
                    </form>
                </div>
            @empty
                <div class="col-span-full py-12 text-center card border-dashed">
                    <p class="text-sm text-slate-500">Nenhuma tag cadastrada ainda.</p>
                </div>
            @endforelse
        </div>
    </div>

</x-layouts.app>
