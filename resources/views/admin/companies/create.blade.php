<x-layouts.app title="Nova Empresa" header="Empresas / Nova">

    <div id="create-company-container" class="max-w-4xl">
        <form id="form-create-company" method="POST" action="{{ route('admin.companies.store') }}" x-data="{ loading: false }" @submit="loading = true">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                {{-- Company Data --}}
                <div class="card">
                    <h2 class="text-base font-semibold text-slate-200 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-octa-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                        Dados da Empresa
                    </h2>

                    <div class="space-y-4">
                        <div>
                            <label for="company_name" class="label">Nome da Empresa <span class="text-red-500">*</span></label>
                            <input type="text" id="company_name" name="name" class="input" placeholder="Razão Social ou Nome Fantasia" required value="{{ old('name') }}">
                        </div>

                        <div>
                            <label for="document" class="label">CNPJ <span class="text-red-500">*</span></label>
                            <input type="text" id="document" name="cnpj" class="input font-mono" placeholder="00.000.000/0000-00" required value="{{ old('cnpj') }}">
                        </div>

                        <div>
                            <label for="subdomain" class="label">Subdomínio <span class="text-red-500">*</span></label>
                            <div class="flex items-center">
                                <input type="text" id="subdomain" name="subdomain" class="input rounded-r-none" placeholder="minha-empresa" required value="{{ old('subdomain') }}">
                                <span class="inline-flex items-center px-3 py-2 rounded-r-lg border border-l-0 border-bg-border bg-bg-secondary text-slate-500 text-sm">
                                    .octabit.tech
                                </span>
                            </div>
                        </div>

                        <div>
                            <label for="plan" class="label">Plano Inicial <span class="text-red-500">*</span></label>
                            <select id="plan" name="plan" class="ajax-select" required>
                                <option value="trial" {{ old('plan') === 'trial' ? 'selected' : '' }}>Trial (15 dias)</option>
                                <option value="basic" {{ old('plan') === 'basic' ? 'selected' : '' }}>Basic</option>
                                <option value="premium" {{ old('plan', 'premium') === 'premium' ? 'selected' : '' }}>Premium</option>
                                <option value="enterprise" {{ old('plan') === 'enterprise' ? 'selected' : '' }}>Enterprise</option>
                            </select>
                        </div>
                    </div>
                </div>

                {{-- Admin User Data --}}
                <div class="card">
                    <h2 class="text-base font-semibold text-slate-200 mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-octa-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                        </svg>
                        Administrador Responsável
                    </h2>

                    <div class="space-y-4">
                        <div>
                            <label for="admin_name" class="label">Nome do Admin <span class="text-red-500">*</span></label>
                            <input type="text" id="admin_name" name="admin_name" class="input" placeholder="Nome completo" required value="{{ old('admin_name') }}">
                        </div>

                        <div>
                            <label for="admin_email" class="label">E-mail do Admin <span class="text-red-500">*</span></label>
                            <input type="email" id="admin_email" name="admin_email" class="input" placeholder="admin@empresa.com" required value="{{ old('admin_email') }}">
                        </div>

                        <div>
                            <label for="admin_password" class="label">Senha <span class="text-red-500">*</span></label>
                            <input type="password" id="admin_password" name="admin_password" class="input" placeholder="••••••••" required>
                        </div>

                        <div>
                            <label for="admin_password_confirmation" class="label">Confirmar Senha <span class="text-red-500">*</span></label>
                            <input type="password" id="admin_password_confirmation" name="admin_password_confirmation" class="input" placeholder="••••••••" required>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Actions --}}
            <div id="form-actions" class="flex items-center gap-3 mt-6 pt-5 border-t border-bg-border">
                <button id="btn-save-company" type="submit" class="btn-primary" :disabled="loading">
                    <svg x-show="loading" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                    </svg>
                    <span x-text="loading ? 'Criando...' : 'Criar Empresa e Administrador'">Criar Empresa e Administrador</span>
                </button>
                <a id="btn-cancel-company" href="{{ route('admin.companies.index') }}" class="btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>

</x-layouts.app>
