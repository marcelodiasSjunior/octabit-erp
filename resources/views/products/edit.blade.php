<x-layouts.app title="Editar Produto" header="Produtos / Editar">

    <div class="max-w-2xl">
        <div class="card">
            <h2 class="text-base font-semibold text-slate-200 mb-6">Editar: {{ $product->name }}</h2>

            <form method="POST" action="{{ route('products.update', $product) }}">
                @csrf @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <div class="sm:col-span-2">
                        <label for="name" class="label">Nome <span class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $product->name) }}"
                               class="input @error('name') input-error @enderror" required/>
                        @error('name') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="type" class="label">Tipo <span class="text-red-500">*</span></label>
                        <select id="type" name="type" class="select @error('type') input-error @enderror" required>
                            @foreach(\App\Enums\ProductType::cases() as $type)
                                <option value="{{ $type->value }}"
                                    {{ old('type', $product->type->value) === $type->value ? 'selected' : '' }}>
                                    {{ $type->label() }}
                                </option>
                            @endforeach
                        </select>
                        @error('type') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="price" class="label">Preço (R$) <span class="text-red-500">*</span></label>
                        <input type="number" id="price" name="price" value="{{ old('price', $product->price) }}"
                               class="input @error('price') input-error @enderror"
                               step="0.01" min="0" required/>
                        @error('price') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="description" class="label">Descrição</label>
                        <textarea id="description" name="description" rows="3"
                                  class="input">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <div class="sm:col-span-2 flex items-center gap-3">
                        <input type="hidden" name="active" value="0"/>
                        <input type="checkbox" id="active" name="active" value="1"
                               {{ old('active', $product->active ? '1' : '0') == '1' ? 'checked' : '' }}
                               class="w-4 h-4 rounded accent-octa-500"/>
                        <label for="active" class="label mb-0">Produto ativo</label>
                    </div>
                </div>

                <div class="flex items-center gap-3 mt-6 pt-4 border-t border-bg-border">
                    <button type="submit" class="btn-primary">Salvar Alterações</button>
                    <a href="{{ route('products.show', $product) }}" class="btn-ghost">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

</x-layouts.app>
