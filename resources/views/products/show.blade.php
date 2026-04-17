<x-layouts.app title="{{ $product->name }}" header="Produtos">

    <div class="max-w-2xl space-y-6">

        @if(session('success'))
            <div class="px-4 py-3 rounded-lg bg-green-500/10 border border-green-500/30 text-green-400 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <div class="card space-y-4">
            <div class="flex items-start justify-between">
                <div>
                    <h2 class="text-lg font-semibold text-slate-100">{{ $product->name }}</h2>
                    <span class="badge mt-1">{{ $product->type->label() }}</span>
                </div>
                <a href="{{ route('products.edit', $product) }}" class="btn-ghost btn-sm">Editar</a>
            </div>

            <dl class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <dt class="text-slate-500">Preço</dt>
                    <dd class="text-slate-200 font-semibold">R$ {{ number_format($product->price, 2, ',', '.') }}</dd>
                </div>
                <div>
                    <dt class="text-slate-500">Status</dt>
                    <dd>
                        @if($product->active)
                            <span class="badge-success">Ativo</span>
                        @else
                            <span class="badge-muted">Inativo</span>
                        @endif
                    </dd>
                </div>
                @if($product->description)
                    <div class="col-span-2">
                        <dt class="text-slate-500">Descrição</dt>
                        <dd class="text-slate-300">{{ $product->description }}</dd>
                    </div>
                @endif
            </dl>
        </div>

        <a href="{{ route('products.index') }}" class="btn-ghost">← Voltar</a>
    </div>

</x-layouts.app>
