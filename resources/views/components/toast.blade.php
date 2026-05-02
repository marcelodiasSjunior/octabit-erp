<div
    x-data="{
        toasts: [],
        add(toast) {
            toast.id = Date.now();
            this.toasts.push(toast);
            setTimeout(() => {
                this.remove(toast.id);
            }, toast.timeout || 5000);
        },
        remove(id) {
            this.toasts = this.toasts.filter(t => t.id !== id);
        }
    }"
    @toast.window="add($event.detail)"
    x-init="
        @if(session('success')) add({ type: 'success', message: '{{ session('success') }}' }); @endif
        @if(session('error')) add({ type: 'error', message: '{{ session('error') }}' }); @endif
        @if(session('warning')) add({ type: 'warning', message: '{{ session('warning') }}' }); @endif
    "
    class="fixed bottom-6 right-6 z-[100] flex flex-col gap-3 pointer-events-none max-w-sm w-full"
>
    <template x-for="toast in toasts" :key="toast.id">
        <div
            x-show="true"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="translate-y-4 opacity-0 scale-95"
            x-transition:enter-end="translate-y-0 opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100"
            x-transition:leave-end="opacity-0 scale-95"
            class="pointer-events-auto flex items-center gap-3 px-4 py-3 rounded-xl border shadow-lg backdrop-blur-md"
            :class="{
                'bg-emerald-500/10 border-emerald-500/20 text-emerald-400': toast.type === 'success',
                'bg-red-500/10 border-red-500/20 text-red-400': toast.type === 'error',
                'bg-amber-500/10 border-amber-500/20 text-amber-400': toast.type === 'warning',
                'bg-slate-800/90 border-slate-700 text-slate-200': !['success', 'error', 'warning'].includes(toast.type)
            }"
        >
            {{-- Icons --}}
            <div class="flex-shrink-0">
                <template x-if="toast.type === 'success'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                </template>
                <template x-if="toast.type === 'error'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                </template>
                <template x-if="toast.type === 'warning'">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </template>
            </div>

            {{-- Message --}}
            <div class="flex-1 text-sm font-medium" x-text="toast.message"></div>

            {{-- Close --}}
            <button @click="remove(toast.id)" class="flex-shrink-0 opacity-50 hover:opacity-100 transition-opacity">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    </template>
</div>
