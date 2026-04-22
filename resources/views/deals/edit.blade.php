<x-layouts.app title="Editar Oportunidade" header="Editar Oportunidade">
    <div class="card max-w-4xl">
        <form method="POST" action="{{ route('deals.update', $deal) }}" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label class="label">Titulo</label>
                <input name="title" value="{{ old('title', $deal->title) }}" class="input" required />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="label">Lead/Cliente</label>
                    <select name="client_id" class="input" required>
                        <option value="">Selecione um lead ou cliente ativo</option>
                        @foreach($clients as $client)
                            <option value="{{ $client->id }}" @selected(old('client_id', $deal->client_id) == $client->id)>
                                {{ $client->display_name }} ({{ $client->status->label() }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="label">Pipeline</label>
                    <select name="pipeline_id" class="input" required>
                        <option value="">Selecione um pipeline</option>
                        @foreach($pipelines as $pipeline)
                            <option value="{{ $pipeline->id }}" @selected(old('pipeline_id', $deal->pipeline_id) == $pipeline->id)>
                                {{ $pipeline->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="label">Etapa</label>
                    <select name="stage_id" class="input" required>
                        <option value="">Selecione uma etapa</option>
                        @foreach($pipelines as $pipeline)
                            @foreach($pipeline->stages as $stage)
                                <option value="{{ $stage->id }}" data-pipeline="{{ $pipeline->id }}" @selected(old('stage_id', $deal->stage_id) == $stage->id)>
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
                    <input name="value" type="number" step="0.01" min="0" value="{{ old('value', $deal->value) }}" class="input" required />
                </div>
                <div>
                    <label class="label">Previsão de Fechamento</label>
                    <input name="expected_close_date" type="date" value="{{ old('expected_close_date', optional($deal->expected_close_date)->toDateString()) }}" class="input" />
                </div>
            </div>

            <div>
                <label class="label">Notas</label>
                <textarea name="notes" class="input" rows="4">{{ old('notes', $deal->notes) }}</textarea>
            </div>

            <div class="flex justify-end gap-3">
                <a href="{{ route('deals.show', $deal) }}" class="btn-ghost">Cancelar</a>
                <button type="submit" class="btn-primary">Salvar</button>
            </div>
        </form>
    </div>
</x-layouts.app>
