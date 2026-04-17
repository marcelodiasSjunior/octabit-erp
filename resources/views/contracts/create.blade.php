<x-layouts.app title="Novo Contrato" header="Contratos / Novo">

    <div class="max-w-2xl">
        <div class="card">
            <h2 class="text-base font-semibold text-slate-200 mb-6">Dados do Contrato</h2>

            <form method="POST" action="{{ route('contracts.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <div class="sm:col-span-2">
                        <label for="client_id" class="label">Cliente <span class="text-red-500">*</span></label>
                        <select id="client_id" name="client_id"
                                class="select @error('client_id') input-error @enderror" required>
                            <option value="">Selecione o cliente...</option>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}"
                                    {{ old('client_id') == $client->id ? 'selected' : '' }}>
                                    {{ $client->name }}{{ $client->company_name ? ' — ' . $client->company_name : '' }}
                                </option>
                            @endforeach
                        </select>
                        @error('client_id') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="value" class="label">Valor (R$) <span class="text-red-500">*</span></label>
                        <input type="number" id="value" name="value" value="{{ old('value') }}"
                               class="input @error('value') input-error @enderror"
                               step="0.01" min="0" placeholder="0,00" required/>
                        @error('value') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="status" class="label">Status <span class="text-red-500">*</span></label>
                        <select id="status" name="status"
                                class="select @error('status') input-error @enderror" required>
                            @foreach(\App\Enums\ContractStatus::cases() as $status)
                                <option value="{{ $status->value }}"
                                    {{ old('status', 'draft') === $status->value ? 'selected' : '' }}>
                                    {{ $status->label() }}
                                </option>
                            @endforeach
                        </select>
                        @error('status') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="start_date" class="label">Início <span class="text-red-500">*</span></label>
                        <input type="date" id="start_date" name="start_date"
                               value="{{ old('start_date', now()->toDateString()) }}"
                               class="input @error('start_date') input-error @enderror" required/>
                        @error('start_date') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="end_date" class="label">Término <span class="text-slate-500 font-normal">(opcional)</span></label>
                        <input type="date" id="end_date" name="end_date" value="{{ old('end_date') }}"
                               class="input"/>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="notes" class="label">Notas <span class="text-slate-500 font-normal">(opcional)</span></label>
                        <textarea id="notes" name="notes" rows="3"
                                  class="input">{{ old('notes') }}</textarea>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="file" class="label">Arquivo do Contrato <span class="text-slate-500 font-normal">(PDF, DOC, DOCX — máx. 10 MB)</span></label>
                        <input type="file" id="file" name="file" accept=".pdf,.doc,.docx"
                               class="block w-full text-sm text-slate-400
                                      file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0
                                      file:text-sm file:font-medium file:bg-octa-600 file:text-white
                                      hover:file:bg-octa-500 cursor-pointer"/>
                        @error('file') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex items-center gap-3 mt-6 pt-4 border-t border-bg-border">
                    <button type="submit" class="btn-primary">Criar Contrato</button>
                    <a href="{{ route('contracts.index') }}" class="btn-ghost">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

</x-layouts.app>
