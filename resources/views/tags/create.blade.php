<x-layouts.app title="Nova Tag" header="Tags / Nova">

    <div class="max-w-md">
        <div class="card">
            <h2 class="text-base font-semibold text-slate-200 mb-6">Criar Nova Tag</h2>

            <form action="{{ route('tags.store') }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label for="name" class="label">Nome da Tag</label>
                        <input type="text" id="name" name="name" class="input" placeholder="ex: Lead Frio" required autofocus>
                    </div>

                    <div>
                        <label for="color" class="label">Cor (Hex)</label>
                        <div class="flex gap-2">
                            <input type="color" id="color_picker" class="h-10 w-12 rounded bg-bg-secondary border-bg-border cursor-pointer" 
                                   oninput="document.getElementById('color').value = this.value">
                            <input type="text" id="color" name="color" class="input font-mono" value="#3b82f6" required>
                        </div>
                    </div>

                    <div>
                        <label for="description" class="label">Descrição (opcional)</label>
                        <textarea id="description" name="description" class="input resize-none" rows="2" placeholder="Para que serve esta tag?"></textarea>
                    </div>
                </div>

                <div class="flex gap-3 mt-6 pt-5 border-t border-bg-border">
                    <button type="submit" class="btn-primary">Criar Tag</button>
                    <a href="{{ route('tags.index') }}" class="btn-ghost">Cancelar</a>
                </div>
            </form>
        </div>
    </div>

</x-layouts.app>
