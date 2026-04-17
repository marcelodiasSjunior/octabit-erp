<?php

declare(strict_types=1);

namespace App\Http\Controllers\Contract;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Services\ContractService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

final class ContractController extends Controller
{
    public function __construct(
        private readonly ContractService $service
    ) {}

    public function index(Request $request): View
    {
        $filters   = $request->only(['search', 'status', 'client_id']);
        $contracts = $this->service->list($filters);

        return view('contracts.index', compact('contracts', 'filters'));
    }

    public function create(): View
    {
        $clients = Client::active()->orderBy('name')->get();
        return view('contracts.create', compact('clients'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'client_id'  => 'required|exists:clients,id',
            'start_date' => 'required|date',
            'end_date'   => 'nullable|date|after:start_date',
            'value'      => 'required|numeric|min:0',
            'status'     => 'required|in:draft,active,expired,canceled',
            'notes'      => 'nullable|string|max:2000',
            'file'       => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        if ($request->hasFile('file')) {
            $validated['file_path'] = $request->file('file')
                ->store('contracts', 'local');
        }
        unset($validated['file']);

        $this->service->create($validated);

        return redirect()->route('contracts.index')
            ->with('success', 'Contrato criado com sucesso.');
    }

    public function show(int $id): View
    {
        $contract = $this->service->findOrFail($id);
        return view('contracts.show', compact('contract'));
    }

    public function edit(int $id): View
    {
        $contract = $this->service->findOrFail($id);
        $clients  = Client::active()->orderBy('name')->get();
        return view('contracts.edit', compact('contract', 'clients'));
    }

    public function update(Request $request, int $id): RedirectResponse
    {
        $validated = $request->validate([
            'client_id'  => 'required|exists:clients,id',
            'start_date' => 'required|date',
            'end_date'   => 'nullable|date|after:start_date',
            'value'      => 'required|numeric|min:0',
            'status'     => 'required|in:draft,active,expired,canceled',
            'notes'      => 'nullable|string|max:2000',
            'file'       => 'nullable|file|mimes:pdf,doc,docx|max:10240',
        ]);

        if ($request->hasFile('file')) {
            $contract = $this->service->findOrFail($id);
            if ($contract->file_path && Storage::disk('local')->exists($contract->file_path)) {
                Storage::disk('local')->delete($contract->file_path);
            }
            $validated['file_path'] = $request->file('file')
                ->store('contracts', 'local');
        }
        unset($validated['file']);

        $this->service->update($id, $validated);

        return redirect()->route('contracts.show', $id)
            ->with('success', 'Contrato atualizado.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $contract = $this->service->findOrFail($id);

        if ($contract->file_path && Storage::disk('local')->exists($contract->file_path)) {
            Storage::disk('local')->delete($contract->file_path);
        }

        $this->service->delete($id);

        return redirect()->route('contracts.index')
            ->with('success', 'Contrato removido.');
    }

    public function download(int $id): StreamedResponse
    {
        $contract = $this->service->findOrFail($id);

        if (!$contract->file_path || !Storage::disk('local')->exists($contract->file_path)) {
            abort(404, 'Arquivo não encontrado.');
        }

        $filename = 'contrato-' . $id . '.' . pathinfo($contract->file_path, PATHINFO_EXTENSION);

        return Storage::disk('local')->download($contract->file_path, $filename);
    }
}
