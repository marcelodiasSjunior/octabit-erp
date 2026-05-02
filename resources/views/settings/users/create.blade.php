<x-layouts.app title="Novo Usuário" header="Configurações / Usuários / Novo">

    <div id="create-user-container" class="max-w-2xl">
        <form id="form-create-user" method="POST" action="{{ route('settings.users.store') }}" x-data="{ loading: false }" @submit="loading = true">
            @csrf

            <div class="card">
                <h2 class="text-base font-semibold text-slate-200 mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-octa-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                    </svg>
                    Dados do Novo Usuário
                </h2>

                <div class="space-y-4">
                    <div>
                        <label for="name" class="label">Nome Completo <span class="text-red-500">*</span></label>
                        <input type="text" id="name" name="name" class="input" placeholder="Ex: João Silva" required value="{{ old('name') }}">
                        @error('name') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="email" class="label">E-mail <span class="text-red-500">*</span></label>
                        <input type="email" id="email" name="email" class="input" placeholder="email@exemplo.com" required value="{{ old('email') }}">
                        @error('email') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label for="role" class="label">Nível de Acesso <span class="text-red-500">*</span></label>
                        <select id="role" name="role" class="ajax-select" required>
                            @foreach($roles as $value => $label)
                                <option value="{{ $value }}" {{ old('role') === $value ? 'selected' : '' }}>{{ $label }}</option>
                            @endforeach
                        </select>
                        @error('role') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="label">Senha <span class="text-red-500">*</span></label>
                            <input type="password" id="password" name="password" class="input" placeholder="••••••••" required>
                            @error('password') <span class="text-xs text-red-500 mt-1">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="password_confirmation" class="label">Confirmar Senha <span class="text-red-500">*</span></label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="input" placeholder="••••••••" required>
                        </div>
                    </div>
                </div>

                {{-- Actions --}}
                <div id="form-actions" class="flex items-center gap-3 mt-8 pt-5 border-t border-bg-border">
                    <button id="btn-save-user" type="submit" class="btn-primary" :disabled="loading">
                        <svg x-show="loading" class="animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"/>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"/>
                        </svg>
                        <span x-text="loading ? 'Salvando...' : 'Salvar Usuário'">Salvar Usuário</span>
                    </button>
                    <a id="btn-cancel-user" href="{{ route('settings.users.index') }}" class="btn-secondary">Cancelar</a>
                </div>
            </div>
        </form>
    </div>

</x-layouts.app>
