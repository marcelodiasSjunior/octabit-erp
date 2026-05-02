<x-layouts.app title="Nova Oportunidade" header="Nova Oportunidade">
    <div id="create-deal-card" class="card max-w-4xl">
        <form id="form-create-deal" method="POST" action="{{ route('deals.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="label">Titulo</label>
                <input id="input-deal-title" name="title" value="{{ old('title') }}" class="input" required />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="label">Lead/Cliente</label>
                    <select id="select-deal-client" name="client_id" class="ajax-select" 
                            data-search-url="{{ route('search.all') }}" required>
                        <option value="">Buscar lead ou cliente ativo...</option>
                        @if(old('client_id'))
                            @php $oldClient = \App\Models\Client::find(old('client_id')); @endphp
                            @if($oldClient)
                                <option value="{{ $oldClient->id }}" selected>{{ $oldClient->display_name }} ({{ $oldClient->status->label() }})</option>
                            @endif
                        @endif
                    </select>
                </div>

                <div>
                    <label class="label">Pipeline</label>
                    <select id="select-deal-pipeline" name="pipeline_id" class="ajax-select" required>
                        <option value="">Selecione um pipeline</option>
                        @foreach($pipelines as $pipeline)
                            <option value="{{ $pipeline->id }}" @selected(old('pipeline_id') == $pipeline->id)>
                                {{ $pipeline->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="label">Etapa</label>
                    <select id="select-deal-stage" name="stage_id" class="ajax-select" required>
                        <option value="">Selecione uma etapa</option>
                        @foreach($pipelines as $pipeline)
                            @foreach($pipeline->stages as $stage)
                                <option value="{{ $stage->id }}" data-pipeline="{{ $pipeline->id }}" @selected(old('stage_id') == $stage->id)>
                                    {{ $pipeline->name }} - {{ $stage->name }}
                                </option>
                            @endforeach
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="label">Valor</label>
                    <input id="input-deal-value" name="value" type="number" step="0.01" min="0" value="{{ old('value') }}" class="input" required />
                </div>
                <div>
                    <label class="label">Previsão de Fechamento</label>
                    <input id="input-deal-close-date" name="expected_close_date" type="date" value="{{ old('expected_close_date') }}" class="input" />
                </div>
            </div>

            <div>
                <label class="label">Notas</label>
                <textarea id="textarea-deal-notes" name="notes" class="input" rows="4">{{ old('notes') }}</textarea>
            </div>

            <div class="flex justify-end gap-3">
                <a id="btn-cancel-deal" href="{{ route('deals.index') }}" class="btn-ghost">Cancelar</a>
                <button id="btn-save-deal" type="submit" class="btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</x-layouts.app>
