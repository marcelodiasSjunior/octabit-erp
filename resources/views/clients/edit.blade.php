@php
    $isLeads = ($segment ?? null) === 'leads' || $client->status === \App\Enums\ClientStatus::Lead;
    $entityLabel = $isLeads ? 'Lead' : 'Cliente';
    $sectionLabel = $isLeads ? 'Leads' : 'Clientes';
@endphp

<x-layouts.app :title="'Editar ' . $entityLabel . ' — ' . $client->name" :header="$sectionLabel . ' / ' . $client->name">

    <div class="max-w-2xl">
        <div class="card">
            <h2 class="text-base font-semibold text-slate-200 mb-6">Editar {{ $entityLabel }}</h2>

            <form method="POST" action="{{ route('clients.update', $client) }}"
                  x-data="{ loading: false }" @submit="loading = true">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label for="name" class="label">Nome completo <span class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name', $client->name) }}"
                               class="input @error('name') input-error @enderror" required/>
                        @error('name') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="company_name" class="label">Empresa</label>
                        <input type="text" id="company_name" name="company_name"
                               value="{{ old('company_name', $client->company_name) }}"
                               class="input"/>
                    </div>

                    <div>
                        <label for="document" class="label">CPF / CNPJ <span class="text-red-500">*</span></label>
                        <input type="text" id="document" name="document"
                               value="{{ old('document', $client->document) }}"
                               class="input font-mono @error('document') input-error @enderror"
                               maxlength="14" required/>
                        @error('document') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="phone" class="label">Telefone</label>
                        <input type="tel" id="phone" name="phone"
                               value="{{ old('phone', $client->phone) }}"
                               class="input"/>
                    </div>

                    <div>
                        <label for="email" class="label">E-mail <span class="text-red-500">*</span></label>
                        <input type="email" id="email" name="email"
                               value="{{ old('email', $client->email) }}"
                               class="input @error('email') input-error @enderror" required/>
                        @error('email') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="status" class="label">Status <span class="text-red-500">*</span></label>
                        <select id="status" name="status"
                                class="select @error('status') input-error @enderror" required>
                            @foreach(\App\Enums\ClientStatus::cases() as $status)
                                <option value="{{ $status->value }}"
                                    {{ old('status', $client->status->value) === $status->value ? 'selected' : '' }}>
                                    {{ $status->label() }}
                                </option>
                            @endforeach
                        </select>
                        @error('status') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label for="notes" class="label">Observações</label>
                        <textarea id="notes" name="notes" rows="3"
                                  class="input resize-none">{{ old('notes', $client->notes) }}</textarea>
                    </div>

                    {{-- Address --}}
                    <div class="sm:col-span-2">
                        <h3 class="label text-slate-500 border-t border-bg-border pt-3 mb-2">Endereço <span class="font-normal">(opcional)</span></h3>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="address" class="label">Logradouro</label>
                        <input type="text" id="address" name="address"
                               value="{{ old('address', $client->address) }}"
                               class="input" placeholder="Rua, número, complemento"/>
                    </div>
                    <div>
                        <label for="city" class="label">Cidade</label>
                        <input type="text" id="city" name="city"
                               value="{{ old('city', $client->city) }}"
                               class="input" placeholder="São Paulo"/>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label for="state" class="label">UF</label>
                            <input type="text" id="state" name="state"
                                   value="{{ old('state', $client->state) }}"
                                   class="input uppercase" placeholder="SP" maxlength="2"/>
                        </div>
                        <div>
                            <label for="zip_code" class="label">CEP</label>
                            <input type="text" id="zip_code" name="zip_code"
                                   value="{{ old('zip_code', $client->zip_code) }}"
                                   class="input" placeholder="00000-000" maxlength="9"/>
                        </div>
                    </div>
                </div>

                <div class="flex items-center gap-3 mt-6 pt-5 border-t border-bg-border">
                    <button type="submit" class="btn-primary" :disabled="loading">
                        <svg x-show="loading" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                        </svg>
                        <span x-text="loading ? 'Salvando...' : 'Salvar alterações'">Salvar alterações</span>
                    </button>
                    <a href="{{ $isLeads ? route('leads.index') : route('clients.show', $client) }}" class="btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

</x-layouts.app>
