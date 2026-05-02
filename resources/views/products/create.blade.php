<x-layouts.app title="Novo Produto" header="Produtos / Novo">

    <div class="max-w-2xl">
        <div class="card">
            <h2 class="text-base font-semibold text-slate-200 mb-6">Dados do Produto</h2>

            <form method="POST" action="{{ route('products.store') }}">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <div class="sm:col-span-2">
                        <label for="name" class="label">Nome <span class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                               class="input @error('name') input-error @enderror"
                               placeholder="Ex: OctaBit SaaS Pro" required/>
                        @error('name') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="type" class="label">Tipo <span class="text-red-500">*</span></label>
                        <select id="type" name="type" class="ajax-select @error('type') input-error @enderror" required>
                            @foreach(\App\Enums\ProductType::cases() as $type)
                                <option value="{{ $type->value }}" {{ old('type') === $type->value ? 'selected' : '' }}>
                                    {{ $type->label() }}
                                </option>
                            @endforeach
                        </select>
                        @error('type') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="price" class="label">Preço (R$) <span class="text-red-500">*</span></label>
                        <input type="number" id="price" name="price" value="{{ old('price') }}"
                               class="input @error('price') input-error @enderror"
                               step="0.01" min="0" placeholder="0,00" required/>
                        @error('price') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="description" class="label">Descrição <span class="text-slate-500 font-normal">(opcional)</span></label>
                        <textarea id="description" name="description" rows="3"
                                  class="input">{{ old('description') }}</textarea>
                    </div>

                    <div class="sm:col-span-2 flex items-center gap-3">
                        <input type="hidden" name="active" value="0"/>
                        <input type="checkbox" id="active" name="active" value="1"
                               {{ old('active', '1') == '1' ? 'checked' : '' }}
                               class="w-4 h-4 rounded accent-octa-500"/>
                        <label for="active" class="label mb-0">Produto ativo</label>
                    </div>
                </div>

                <div class="flex items-center gap-3 mt-6 pt-4 border-t border-bg-border">
                    <button type="submit" class="btn-primary">Criar Produto</button>
                    <a href="{{ route('products.index') }}" class="btn-ghost">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

</x-layouts.app>
