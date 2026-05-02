<div
    x-data="{
        open: false,
        title: '',
        message: '',
        type: 'confirm',
        confirmText: 'Confirmar',
        cancelText: 'Cancelar',
        onConfirm: null,

        show(options) {
            this.title = options.title || 'Confirmação';
            this.message = options.message || 'Deseja prosseguir com esta ação?';
            this.type = options.type || 'confirm';
            this.confirmText = options.confirmText || (this.type === 'danger' ? 'Excluir' : 'Confirmar');
            this.cancelText = options.cancelText || 'Cancelar';
            this.onConfirm = options.onConfirm || null;
            this.open = true;
        },
        confirm() {
            if (this.onConfirm) this.onConfirm();
            this.open = false;
        }
    }"
    @dialog.window="show($event.detail)"
    x-show="open"
    x-cloak
    class="fixed inset-0 z-[90] flex items-center justify-center p-4 overflow-y-auto"
>
    {{-- Backdrop --}}
    <div
        x-show="open"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-slate-950/60 backdrop-blur-sm"
        @click="open = false"
    ></div>

    {{-- Modal --}}
    <div
        x-show="open"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        class="relative w-full max-w-md bg-bg-secondary border border-bg-border rounded-2xl shadow-2xl overflow-hidden"
    >
        <div class="p-6">
            <div class="flex items-start gap-4">
                {{-- Icon based on type --}}
                <div class="flex-shrink-0 w-10 h-10 rounded-full flex items-center justify-center"
                     :class="{
                        'bg-red-500/10 text-red-500': type === 'danger',
                        'bg-octa-500/10 text-octa-400': type === 'confirm',
                        'bg-amber-500/10 text-amber-500': type === 'alert'
                     }">
                    <template x-if="type === 'danger'">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                    </template>
                    <template x-if="type === 'confirm'">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </template>
                </div>

                <div class="flex-1">
                    <h3 class="text-lg font-bold text-slate-100" x-text="title"></h3>
                    <p class="mt-2 text-sm text-slate-400 leading-relaxed" x-text="message"></p>
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="px-6 py-4 bg-bg-input/50 flex flex-col sm:flex-row-reverse gap-3">
            <button
                @click="confirm()"
                class="w-full sm:w-auto px-4 py-2 text-sm font-semibold rounded-lg transition-all"
                :class="{
                    'bg-red-600 hover:bg-red-500 text-white shadow-lg shadow-red-600/20': type === 'danger',
                    'bg-octa-600 hover:bg-octa-500 text-white shadow-lg shadow-octa-600/20': type === 'confirm',
                    'bg-amber-600 hover:bg-amber-500 text-white shadow-lg shadow-amber-600/20': type === 'alert'
                }"
                x-text="confirmText"
            ></button>
            <button
                @click="open = false"
                class="w-full sm:w-auto px-4 py-2 text-sm font-medium text-slate-400 hover:text-slate-200 hover:bg-slate-800 rounded-lg transition-colors"
                x-text="cancelText"
            ></button>
        </div>
    </div>
</div>
