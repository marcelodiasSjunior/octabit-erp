<?php

declare(strict_types=1);

namespace App\Http\Requests\Client;

use App\Enums\ClientStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

final class UpdateClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role?->can('clients.edit') ?? false;
    }

    public function rules(): array
    {
        $clientId = $this->route('client') ?? $this->route('id');

        return [
            'name'         => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            // Ignore the current record's own email/document on update
            'document'     => "required|string|max:20|unique:clients,document,{$clientId}",
            'email'        => "required|email|max:255|unique:clients,email,{$clientId}",
            'phone'        => 'nullable|string|max:20',
            'status'       => ['required', new Enum(ClientStatus::class)],
            'notes'        => 'nullable|string|max:2000',
            'zip_code'     => 'nullable|string|max:9',
            'address'      => 'nullable|string|max:255',
            'city'         => 'nullable|string|max:100',
            'state'        => 'nullable|string|size:2',
        ];
    }

    public function messages(): array
    {
        return [
            'document.unique' => 'Este CPF/CNPJ já está em uso por outro cliente.',
            'email.unique'    => 'Este e-mail já está em uso por outro cliente.',
            'email.email'     => 'Informe um e-mail válido.',
            'status.required' => 'Informe o status do cliente.',
        ];
    }
}
