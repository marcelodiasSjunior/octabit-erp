<?php

declare(strict_types=1);

namespace App\Http\Controllers\Settings;

use App\Enums\UserRole;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $userService
    ) {}

    public function index(Request $request)
    {
        $user = $request->user();
        $users = $this->userService->listUsersByCompany($user->company_id);

        return view('settings.users.index', compact('users'));
    }

    public function create()
    {
        $roles = [
            UserRole::AdminEmpresa->value => UserRole::AdminEmpresa->label(),
            UserRole::Manager->value      => UserRole::Manager->label(),
            UserRole::Operator->value     => UserRole::Operator->label(),
            UserRole::User->value         => UserRole::User->label(),
        ];

        return view('settings.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role'     => ['required', Rule::in([
                UserRole::AdminEmpresa->value,
                UserRole::Manager->value,
                UserRole::Operator->value,
                UserRole::User->value
            ])],
        ]);

        $validated['company_id'] = $request->user()->company_id;

        $this->userService->createUser($validated);

        return redirect()->route('settings.users.index')
            ->with('success', 'Usuário criado com sucesso.');
    }

    public function edit(User $user)
    {
        // Ensure the admin can only edit users from their own company
        if ($user->company_id !== auth()->user()->company_id && !auth()->user()->isMasterGlobal()) {
            abort(403);
        }

        $roles = [
            UserRole::AdminEmpresa->value => UserRole::AdminEmpresa->label(),
            UserRole::Manager->value      => UserRole::Manager->label(),
            UserRole::Operator->value     => UserRole::Operator->label(),
            UserRole::User->value         => UserRole::User->label(),
        ];

        return view('settings.users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        // Ensure the admin can only update users from their own company
        if ($user->company_id !== $request->user()->company_id && !$request->user()->isMasterGlobal()) {
            abort(403);
        }

        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => ['required', 'email', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role'     => ['required', Rule::in([
                UserRole::AdminEmpresa->value,
                UserRole::Manager->value,
                UserRole::Operator->value,
                UserRole::User->value
            ])],
        ]);

        $this->userService->updateUser($user, $validated);

        return redirect()->route('settings.users.index')
            ->with('success', 'Usuário atualizado com sucesso.');
    }

    public function destroy(User $user)
    {
        // Ensure the admin can only delete users from their own company
        if ($user->company_id !== auth()->user()->company_id && !auth()->user()->isMasterGlobal()) {
            abort(403);
        }

        if ($user->id === auth()->id()) {
            return redirect()->route('settings.users.index')
                ->with('error', 'Você não pode excluir seu próprio usuário.');
        }

        $this->userService->deleteUser($user);

        return redirect()->route('settings.users.index')
            ->with('success', 'Usuário excluído com sucesso.');
    }
}
