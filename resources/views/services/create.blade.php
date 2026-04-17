<x-layouts.app title="Novo Serviço" header="Serviços / Novo">

    <div class="max-w-2xl">
        <div class="card">
            <h2 class="text-base font-semibold text-slate-200 mb-6">Dados do Serviço</h2>

            <form method="POST" action="{{ route('services.store') }}">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <div class="sm:col-span-2">
                        <label for="name" class="label">Nome <span class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                               class="input @error('name') input-error @enderror"
                               placeholder="Ex: Suporte Técnico Mensal" required/>
                        @error('name') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="type" class="label">Tipo <span class="text-red-500">*</span></label>
                        <select id="type" name="type" class="select @error('type') input-error @enderror" required>
                            @foreach(\App\Enums\ServiceType::cases() as $type)
                                <option value="{{ $type->value }}" {{ old('type') === $type->value ? 'selected' : '' }}>
                                    {{ $type->label() }}
                                </option>
                            @endforeach
                        </select>
                        @error('type') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="base_price" class="label">Preço Base (R$) <span class="text-red-500">*</span></label>
                        <input type="number" id="base_price" name="base_price" value="{{ old('base_price') }}"
                               class="input @error('base_price') input-error @enderror"
                               step="0.01" min="0" placeholder="0,00" required/>
                        @error('base_price') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="setup_price" class="label">Taxa de Setup (R$) <span class="text-slate-500 font-normal">(opcional)</span></label>
                        <input type="number" id="setup_price" name="setup_price" value="{{ old('setup_price') }}"
                               class="input" step="0.01" min="0" placeholder="0,00"/>
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
                        <label for="active" class="label mb-0">Serviço ativo</label>
                    </div>
                </div>

                <div class="flex items-center gap-3 mt-6 pt-4 border-t border-bg-border">
                    <button type="submit" class="btn-primary">Criar Serviço</button>
                    <a href="{{ route('services.index') }}" class="btn-ghost">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

</x-layouts.app>
