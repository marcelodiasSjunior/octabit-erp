<?php

declare(strict_types=1);

namespace App\Http\Requests\Deal;

use Illuminate\Foundation\Http\FormRequest;

final class UpdateDealRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->role?->can('deals.edit') ?? true;
    }

    public function rules(): array
    {
        return [
            'client_id'           => ['required', 'exists:clients,id'],
            'pipeline_id'         => ['required', 'exists:pipelines,id'],
            'stage_id'            => ['required', 'exists:pipeline_stages,id'],
            'title'               => ['required', 'string', 'max:255'],
            'value'               => ['required', 'numeric', 'min:0'],
            'expected_close_date' => ['nullable', 'date'],
            'notes'               => ['nullable', 'string', 'max:2000'],
        ];
    }
}
