<?php

declare(strict_types=1);

namespace App\Http\Requests\Client;

use App\Enums\ClientStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

final class StoreClientRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role?->can('clients.create') ?? false;
    }

    public function rules(): array
    {
        return [
            'name'         => 'required|string|max:255',
            'company_name' => 'nullable|string|max:255',
            'document'     => 'required|string|max:20|unique:clients,document',
            'email'        => 'required|email|max:255|unique:clients,email',
            'phone'        => 'nullable|string|max:20',
            'status'       => ['required', new Enum(ClientStatus::class)],
            'notes'        => 'nullable|string|max:2000',
            'zip_code'     => 'nullable|string|max:9',
            'address'      => 'nullable|string|max:255',
            'city'         => 'nullable|string|max:100',
            'state'        => 'nullable|string|size:2',
            'tags'         => 'nullable|array',
            'tags.*'       => 'exists:tags,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'O nome é obrigatório.',
            'document.required' => 'O CPF/CNPJ é obrigatório.',
            'document.unique'   => 'Este CPF/CNPJ já está cadastrado.',
            'email.required'    => 'O e-mail é obrigatório.',
            'email.email'       => 'Informe um e-mail válido.',
            'email.unique'      => 'Este e-mail já está cadastrado.',
            'status.required'   => 'Informe o status do cliente.',
        ];
    }
}
