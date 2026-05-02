<x-layouts.app title="Produtos" header="Produtos">

    <div id="products-toolbar" class="flex flex-col sm:flex-row sm:items-center gap-3 mb-6">
        <form method="GET" action="{{ route('products.index') }}"
              class="flex flex-1 flex-wrap gap-3" id="filter-form">
            <input id="input-search-products" type="search" name="search" value="{{ $filters['search'] ?? '' }}"
                   placeholder="Buscar por nome..." class="input flex-1 max-w-xs"/>

            <select id="select-type" name="type" class="ajax-select w-auto" onchange="document.getElementById('filter-form').submit()">
                <option value="">Todos os tipos</option>
                @foreach(\App\Enums\ProductType::cases() as $type)
                    <option value="{{ $type->value }}"
                        {{ ($filters['type'] ?? '') === $type->value ? 'selected' : '' }}>
                        {{ $type->label() }}
                    </option>
                @endforeach
            </select>

            @if(!empty($filters['search']) || !empty($filters['type']))
                <a id="btn-clear-filters" href="{{ route('products.index') }}" class="btn-ghost btn-sm self-center">Limpar</a>
            @endif
        </form>

        <a id="btn-create-product" href="{{ route('products.create') }}" class="btn-primary whitespace-nowrap self-start sm:self-auto">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Novo Produto
        </a>
    </div>

    @if(session('success'))
        <div id="flash-success" class="mb-4 px-4 py-3 rounded-lg bg-green-500/10 border border-green-500/30 text-green-400 text-sm">
            {{ session('success') }}
        </div>
    @endif

    <div id="products-table-container" class="table-wrapper">
        <table id="products-table" class="table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Tipo</th>
                    <th>Preço</th>
                    <th>Status</th>
                    <th class="text-right">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr id="product-row-{{ $product->id }}">
                        <td>
                            <div id="product-name-{{ $product->id }}" class="font-medium text-slate-200">{{ $product->name }}</div>
                            @if($product->description)
                                <div id="product-desc-{{ $product->id }}" class="text-xs text-slate-500 truncate max-w-xs">{{ $product->description }}</div>
                            @endif
                        </td>
                        <td><span id="product-type-badge-{{ $product->id }}" class="badge">{{ $product->type->label() }}</span></td>
                        <td id="product-price-{{ $product->id }}" class="font-semibold text-slate-200">R$ {{ number_format($product->price, 2, ',', '.') }}</td>
                        <td>
                            @if($product->active)
                                <span id="product-status-active-{{ $product->id }}" class="badge-success">Ativo</span>
                            @else
                                <span id="product-status-inactive-{{ $product->id }}" class="badge-muted">Inativo</span>
                            @endif
                        </td>
                        <td>
                            <div class="flex items-center justify-end gap-2">
                                <a id="btn-view-product-{{ $product->id }}" href="{{ route('products.show', $product) }}" class="btn-ghost btn-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0zM2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </a>
                                <a id="btn-edit-product-{{ $product->id }}" href="{{ route('products.edit', $product) }}" class="btn-ghost btn-sm">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </a>
                                <form id="delete-form-product-{{ $product->id }}" method="POST" action="{{ route('products.destroy', $product) }}"
                                      x-data @submit.prevent="$dispatch('dialog', { 
                                          title: 'Remover Produto', 
                                          message: 'Deseja realmente excluir o produto \'{{ addslashes($product->name) }}\'?',
                                          type: 'danger',
                                          onConfirm: () => $el.submit()
                                      })">
                                    @csrf @method('DELETE')
                                    <button id="btn-delete-product-{{ $product->id }}" type="submit" class="btn-ghost btn-sm text-red-500 hover:text-red-400">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr id="no-products-row">
                        <td colspan="5" class="text-center py-12 text-slate-500">
                            Nenhum produto encontrado. <a id="link-create-first-product" href="{{ route('products.create') }}" class="text-octa-400 hover:underline">Cadastre o primeiro.</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($products->hasPages())
        <div class="mt-4">{{ $products->links() }}</div>
    @endif

</x-layouts.app>
