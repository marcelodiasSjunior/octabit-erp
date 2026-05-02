<x-layouts.app title="Editar Serviço" header="Serviços / Editar">

    <div class="max-w-2xl">
        <div class="card">
            <h2 class="text-base font-semibold text-slate-200 mb-6">Editar: {{ $service->name }}</h2>

            <form method="POST" action="{{ route('services.update', $service) }}">
                @csrf @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <div class="sm:col-span-2">
                        <label for="name" class="label">Nome <span class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $service->name) }}"
                               class="input @error('name') input-error @enderror" required/>
                        @error('name') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="type" class="label">Tipo <span class="text-red-500">*</span></label>
                        <select id="type" name="type" class="ajax-select @error('type') input-error @enderror" required>
                            @foreach(\App\Enums\ServiceType::cases() as $type)
                                <option value="{{ $type->value }}"
                                    {{ old('type', $service->type->value) === $type->value ? 'selected' : '' }}>
                                    {{ $type->label() }}
                                </option>
                            @endforeach
                        </select>
                        @error('type') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="base_price" class="label">Preço Base (R$) <span class="text-red-500">*</span></label>
                        <input type="number" id="base_price" name="base_price"
                               value="{{ old('base_price', $service->base_price) }}"
                               class="input @error('base_price') input-error @enderror"
                               step="0.01" min="0" required/>
                        @error('base_price') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="setup_price" class="label">Taxa de Setup (R$)</label>
                        <input type="number" id="setup_price" name="setup_price"
                               value="{{ old('setup_price', $service->setup_price) }}"
                               class="input" step="0.01" min="0"/>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="description" class="label">Descrição</label>
                        <textarea id="description" name="description" rows="3"
                                  class="input">{{ old('description', $service->description) }}</textarea>
                    </div>

                    <div class="sm:col-span-2 flex items-center gap-3">
                        <input type="hidden" name="active" value="0"/>
                        <input type="checkbox" id="active" name="active" value="1"
                               {{ old('active', $service->active ? '1' : '0') == '1' ? 'checked' : '' }}
                               class="w-4 h-4 rounded accent-octa-500"/>
                        <label for="active" class="label mb-0">Serviço ativo</label>
                    </div>
                </div>

                <div class="flex items-center gap-3 mt-6 pt-4 border-t border-bg-border">
                    <button type="submit" class="btn-primary">Salvar Alterações</button>
                    <a href="{{ route('services.show', $service) }}" class="btn-ghost">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

</x-layouts.app>
