<x-layouts.app title="Nova Conta a Pagar" header="Contas a Pagar / Nova">

    <div class="max-w-2xl">
        <div class="card">
            <h2 class="text-base font-semibold text-slate-200 mb-6">Dados da Conta a Pagar</h2>

            <form method="POST" action="{{ route('payable.store') }}">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <div class="sm:col-span-2">
                        <label for="description" class="label">Descrição <span class="text-red-500">*</span></label>
                        <input type="text" id="description" name="description" value="{{ old('description') }}"
                               class="input @error('description') input-error @enderror"
                               placeholder="Ex: Licença de software, Hospedagem..." required/>
                        @error('description') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="amount" class="label">Valor (R$) <span class="text-red-500">*</span></label>
                        <input type="number" id="amount" name="amount" value="{{ old('amount') }}"
                               class="input @error('amount') input-error @enderror"
                               step="0.01" min="0.01" placeholder="0,00" required/>
                        @error('amount') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="due_date" class="label">Vencimento <span class="text-red-500">*</span></label>
                        <input type="date" id="due_date" name="due_date"
                               value="{{ old('due_date', now()->toDateString()) }}"
                               class="input @error('due_date') input-error @enderror" required/>
                        @error('due_date') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="category" class="label">Categoria <span class="text-slate-500 font-normal">(opcional)</span></label>
                        <input type="text" id="category" name="category" value="{{ old('category') }}"
                               class="input"
                               placeholder="Ex: Infraestrutura, Marketing, RH..."/>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="notes" class="label">Notas <span class="text-slate-500 font-normal">(opcional)</span></label>
                        <textarea id="notes" name="notes" rows="3"
                                  class="input">{{ old('notes') }}</textarea>
                    </div>
                </div>

                <div class="flex items-center gap-3 mt-6 pt-4 border-t border-bg-border">
                    <button type="submit" class="btn-primary">Criar Conta</button>
                    <a href="{{ route('payable.index') }}" class="btn-ghost">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

</x-layouts.app>
