<x-layouts.app title="Nova Cobrança" header="Contas a Receber / Nova Cobrança">

    <div class="max-w-xl">
        <div class="card">
            <h2 class="text-base font-semibold text-slate-200 mb-6">Dados da Cobrança</h2>

            <form method="POST" action="{{ route('receivable.store') }}"
                  x-data="{ loading: false }" @submit="loading = true">
                @csrf

                <div class="space-y-4">
                    {{-- Client --}}
                    <div>
                        <label for="client_id" class="label">Cliente <span class="text-red-500">*</span></label>
                        <select id="client_id" name="client_id"
                                class="select @error('client_id') input-error @enderror" required>
                            <option value="">Selecione um cliente...</option>
                            @foreach(\App\Models\Client::orderBy('name')->get() as $client)
                                <option value="{{ $client->id }}"
                                    {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                    {{ $client->name }}{{ $client->company_name ? ' — ' . $client->company_name : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('client_id') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- Description --}}
                    <div>
                        <label for="description" class="label">Descrição <span class="text-red-500">*</span></label>
                        <input type="text" id="description" name="description"
                               value="{{ old('description') }}"
                               class="input @error('description') input-error @enderror"
                               placeholder="Ex: Mensalidade — Hospedagem — Janeiro/2025" required/>
                        @error('description') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        {{-- Amount --}}
                        <div>
                            <label for="amount" class="label">Valor (R$) <span class="text-red-500">*</span></label>
                            <input type="number" id="amount" name="amount"
                                   value="{{ old('amount') }}"
                                   class="input @error('amount') input-error @enderror"
                                   min="0.01" step="0.01"
                                   placeholder="0,00" required/>
                            @error('amount') <p class="form-error">{{ $message }}</p> @enderror
                        </div>

                        {{-- Due date --}}
                        <div>
                            <label for="due_date" class="label">Vencimento <span class="text-red-500">*</span></label>
                            <input type="date" id="due_date" name="due_date"
                                   value="{{ old('due_date') }}"
                                   class="input @error('due_date') input-error @enderror"
                                   required/>
                            @error('due_date') <p class="form-error">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Notes --}}
                    <div>
                        <label for="notes" class="label">Observações</label>
                        <textarea id="notes" name="notes" rows="2"
                                  class="input resize-none"
                                  placeholder="Referência, número de NF, etc.">{{ old('notes') }}</textarea>
                    </div>
                </div>

                <div class="flex items-center gap-3 mt-6 pt-5 border-t border-bg-border">
                    <button type="submit" class="btn-primary" :disabled="loading">
                        <svg x-show="loading" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                        </svg>
                        <span x-text="loading ? 'Criando...' : 'Criar cobrança'">Criar cobrança</span>
                    </button>
                    <a href="{{ route('receivable.index') }}" class="btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

</x-layouts.app>
