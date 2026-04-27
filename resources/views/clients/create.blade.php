@php
    $isLeads = ($segment ?? 'clients') === 'leads';
    $pageTitle = $isLeads ? 'Novo Lead' : 'Novo Cliente';
    $header = $isLeads ? 'Leads / Novo' : 'Clientes / Novo';
    $storeRoute = $isLeads ? 'leads.store' : 'clients.store';
    $backRoute = $isLeads ? 'leads.index' : 'clients.index';
@endphp

<x-layouts.app :title="$pageTitle" :header="$header">

    <div class="max-w-2xl">
        <div class="card">
            <h2 class="text-base font-semibold text-slate-200 mb-6">Dados do {{ $isLeads ? 'Lead' : 'Cliente' }}</h2>

            <form id="form-create-client" method="POST" action="{{ route($storeRoute) }}" x-data="{ loading: false }" @submit="loading = true">
                @csrf

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    {{-- ... (fields already have IDs) ... --}}

                    {{-- Name --}}
                    <div class="sm:col-span-2">
                        <label for="name" class="label">Nome completo <span class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                               class="input @error('name') input-error @enderror"
                               placeholder="João da Silva" required/>
                        @error('name') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- Company --}}
                    <div class="sm:col-span-2">
                        <label for="company_name" class="label">
                            Empresa
                            <span class="text-slate-600 font-normal">(opcional)</span>
                        </label>
                        <input type="text" id="company_name" name="company_name" value="{{ old('company_name') }}"
                               class="input"
                               placeholder="Empresa Ltda."/>
                    </div>

                    {{-- Document --}}
                    <div>
                        <label for="document" class="label">
                            CPF / CNPJ <span class="text-red-500">*</span>
                            <span class="text-slate-600 font-normal text-xs ml-1" title="Apenas dígitos">(somente números)</span>
                        </label>
                        <input type="text" id="document" name="document" value="{{ old('document') }}"
                               class="input font-mono @error('document') input-error @enderror"
                               placeholder="00000000000"
                               maxlength="14" required/>
                        @error('document') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- Phone --}}
                    <div>
                        <label for="phone" class="label">Telefone <span class="text-slate-600 font-normal">(opcional)</span></label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}"
                               class="input"
                               placeholder="(11) 99999-0000"/>
                    </div>

                    {{-- Email --}}
                    <div>
                        <label for="email" class="label">E-mail <span class="text-red-500">*</span></label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                               class="input @error('email') input-error @enderror"
                               placeholder="cliente@empresa.com" required/>
                        @error('email') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- Status --}}
                    <div>
                        <label for="status" class="label">Status <span class="text-red-500">*</span></label>
                        @if($isLeads)
                            <input type="hidden" name="status" value="{{ \App\Enums\ClientStatus::Lead->value }}" />
                            <div class="input flex items-center text-slate-300">Lead</div>
                        @else
                            <select id="status" name="status"
                                    class="select @error('status') input-error @enderror" required>
                                @foreach(\App\Enums\ClientStatus::cases() as $status)
                                    @continue($status === \App\Enums\ClientStatus::Lead)
                                    <option value="{{ $status->value }}"
                                        {{ old('status', \App\Enums\ClientStatus::Active->value) === $status->value ? 'selected' : '' }}>
                                        {{ $status->label() }}
                                    </option>
                                @endforeach
                            </select>
                        @endif
                        @error('status') <p class="form-error">{{ $message }}</p> @enderror
                    </div>

                    {{-- Notes --}}
                    <div class="sm:col-span-2">
                        <label for="notes" class="label">Observações <span class="text-slate-600 font-normal">(opcional)</span></label>
                        <textarea id="notes" name="notes" rows="3"
                                  class="input resize-none"
                                  placeholder="Informações adicionais sobre o cliente...">{{ old('notes') }}</textarea>
                    </div>

                    {{-- Address --}}
                    <div class="sm:col-span-2">
                        <h3 class="label text-slate-500 border-t border-bg-border pt-3 mb-2">Endereço <span class="font-normal">(opcional)</span></h3>
                    </div>
                    <div class="sm:col-span-2">
                        <label for="address" class="label">Logradouro</label>
                        <input type="text" id="address" name="address" value="{{ old('address') }}"
                               class="input" placeholder="Rua, número, complemento"/>
                    </div>
                    <div>
                        <label for="city" class="label">Cidade</label>
                        <input type="text" id="city" name="city" value="{{ old('city') }}"
                               class="input" placeholder="São Paulo"/>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label for="state" class="label">UF</label>
                            <input type="text" id="state" name="state" value="{{ old('state') }}"
                                   class="input uppercase" placeholder="SP" maxlength="2"/>
                        </div>
                        <div>
                            <label for="zip_code" class="label">CEP</label>
                            <input type="text" id="zip_code" name="zip_code" value="{{ old('zip_code') }}"
                                   class="input" placeholder="00000-000" maxlength="9"/>
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-3 mt-6 pt-5 border-t border-bg-border">
                    <button id="btn-save-client" type="submit" class="btn-primary" :disabled="loading">
                        <svg x-show="loading" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                        </svg>
                        <span x-text="loading ? 'Salvando...' : '{{ $isLeads ? 'Salvar lead' : 'Salvar cliente' }}'">{{ $isLeads ? 'Salvar lead' : 'Salvar cliente' }}</span>
                    </button>
                    <a id="btn-cancel-client" href="{{ route($backRoute) }}" class="btn-secondary">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

</x-layouts.app>
