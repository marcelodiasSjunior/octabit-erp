<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\TagService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TagController extends Controller
{
    public function __construct(
        private readonly TagService $service
    ) {}

    public function index(): View
    {
        $tags = $this->service->list();
        return view('tags.index', compact('tags'));
    }

    public function create(): View
    {
        return view('tags.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:50|unique:tags,name',
            'color'       => 'required|string|max:7',
            'description' => 'nullable|string|max:255',
        ]);

        $this->service->create($validated);

        return redirect()->route('tags.index')->with('success', 'Tag criada com sucesso.');
    }

    public function destroy(int $id): RedirectResponse
    {
        $this->service->delete($id);
        return redirect()->route('tags.index')->with('success', 'Tag removida.');
    }
}
