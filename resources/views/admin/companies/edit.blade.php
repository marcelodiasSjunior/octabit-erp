<x-layouts.app title="Editar Empresa" header="Empresas / Editar">

    <div id="edit-company-container" class="max-w-2xl">
        <form id="form-edit-company" method="POST" action="{{ route('admin.companies.update', $company) }}" x-data="{ loading: false }" @submit="loading = true">
            @csrf
            @method('PUT')

            <div class="card">
                <h2 class="text-base font-semibold text-slate-200 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-octa-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    Dados da Empresa: {{ $company->name }}
                </h2>

                <div class="space-y-4">
                    <div>
                        <label for="company_name" class="label">Nome da Empresa <span class="text-red-500">*</span></label>
                        <input type="text" id="company_name" name="name" class="input" placeholder="Razão Social ou Nome Fantasia" required value="{{ old('name', $company->name) }}">
                        @error('name') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="cnpj" class="label">CNPJ</label>
                        <input type="text" id="cnpj" name="cnpj" class="input font-mono" placeholder="00.000.000/0000-00" value="{{ old('cnpj', $company->cnpj) }}">
                        @error('cnpj') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="status" class="label">Status do Acesso <span class="text-red-500">*</span></label>
                        <select id="status" name="status" class="ajax-select" required>
                            <option value="active" {{ old('status', $company->status) === 'active' ? 'selected' : '' }}>Ativa</option>
                            <option value="inactive" {{ old('status', $company->status) === 'inactive' ? 'selected' : '' }}>Inativa / Bloqueada</option>
                        </select>
                        @error('status') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="plan" class="label">Plano de Assinatura <span class="text-red-500">*</span></label>
                        <select id="plan" name="plan" class="ajax-select" required>
                            <option value="trial" {{ old('plan', $company->plan) === 'trial' ? 'selected' : '' }}>Trial (15 dias)</option>
                            <option value="basic" {{ old('plan', $company->plan) === 'basic' ? 'selected' : '' }}>Basic</option>
                            <option value="premium" {{ old('plan', $company->plan) === 'premium' ? 'selected' : '' }}>Premium</option>
                            <option value="enterprise" {{ old('plan', $company->plan) === 'enterprise' ? 'selected' : '' }}>Enterprise</option>
                        </select>
                        @error('plan') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- Actions --}}
                <div id="form-actions" class="flex items-center gap-3 mt-8 pt-5 border-t border-bg-border">
                    <button id="btn-save-company" type="submit" class="btn-primary" :disabled="loading">
                        <svg x-show="loading" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                        </svg>
                        <span x-text="loading ? 'Salvando...' : 'Salvar Alterações'">Salvar Alterações</span>
                    </button>
                    <a id="btn-cancel-company" href="{{ route('admin.companies.index') }}" class="btn-secondary">Cancelar</a>
                </div>
            </div>
        </form>
    </div>

</x-layouts.app>
