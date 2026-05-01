<x-layouts.app title="Editar Contrato" header="Contratos / Editar">

    <div class="max-w-2xl">
        <div class="card">
            <h2 class="text-base font-semibold text-slate-200 mb-6">Editar Contrato</h2>

            <form method="POST" action="{{ route('contracts.update', $contract) }}" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">

                    <div class="sm:col-span-2">
                        <label for="client_id" class="label">Cliente <span class="text-red-500">*</span></label>
                        <select id="client_id" name="client_id"
                                class="form-select ajax-select @error('client_id') input-error @enderror"
                                data-search-url="{{ route('search.clients') }}"
                                required>
                            @php 
                                $selectedId = old('client_id', $contract->client_id);
                                $selectedClient = \App\Models\Client::find($selectedId);
                            @endphp
                            @if($selectedClient)
                                <option value="{{ $selectedClient->id }}" selected>{{ $selectedClient->display_name }}</option>
                            @else
                                <option value="">Buscar cliente...</option>
                            @endif
                        </select>
                        @error('client_id') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="value" class="label">Valor (R$) <span class="text-red-500">*</span></label>
                        <input type="number" id="value" name="value"
                               value="{{ old('value', $contract->value) }}"
                               class="input @error('value') input-error @enderror"
                               step="0.01" min="0" required/>
                        @error('value') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="status" class="label">Status <span class="text-red-500">*</span></label>
                        <select id="status" name="status"
                                class="select @error('status') input-error @enderror" required>
                            @foreach(\App\Enums\ContractStatus::cases() as $status)
                                <option value="{{ $status->value }}"
                                    {{ old('status', $contract->status->value) === $status->value ? 'selected' : '' }}>
                                    {{ $status->label() }}
                                </option>
                            @endforeach
                        </select>
                        @error('status') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="start_date" class="label">Início <span class="text-red-500">*</span></label>
                        <input type="date" id="start_date" name="start_date"
                               value="{{ old('start_date', $contract->start_date->toDateString()) }}"
                               class="input @error('start_date') input-error @enderror" required/>
                        @error('start_date') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="end_date" class="label">Término</label>
                        <input type="date" id="end_date" name="end_date"
                               value="{{ old('end_date', $contract->end_date?->toDateString()) }}"
                               class="input"/>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="notes" class="label">Notas</label>
                        <textarea id="notes" name="notes" rows="3"
                                  class="input">{{ old('notes', $contract->notes) }}</textarea>
                    </div>

                    <div class="sm:col-span-2">
                        <label class="label">Arquivo do Contrato</label>
                        @if($contract->file_path)
                            <div class="flex items-center gap-3 mb-2 p-3 rounded-lg bg-bg-input border border-bg-border text-sm">
                                <svg class="w-5 h-5 text-octa-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13"/>
                                </svg>
                                <span class="text-slate-300 flex-1">{{ basename($contract->file_path) }}</span>
                                <a href="{{ route('contracts.download', $contract->id) }}" class="text-octa-400 hover:text-octa-300 font-medium">Baixar</a>
                            </div>
                            <p class="text-xs text-slate-500 mb-2">Selecione um novo arquivo para substituir o atual:</p>
                        @endif
                        <input type="file" id="file" name="file" accept=".pdf,.doc,.docx"
                               class="block w-full text-sm text-slate-400
                                      file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0
                                      file:text-sm file:font-medium file:bg-octa-600 file:text-white
                                      hover:file:bg-octa-500 cursor-pointer"/>
                        <p class="text-xs text-slate-500 mt-1">PDF, DOC, DOCX — máx. 10 MB</p>
                        @error('file') <p class="form-error">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="flex items-center gap-3 mt-6 pt-4 border-t border-bg-border">
                    <button type="submit" class="btn-primary">Salvar Alterações</button>
                    <a href="{{ route('contracts.show', $contract) }}" class="btn-ghost">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

</x-layouts.app>
