<?php

declare(strict_types=1);

namespace App\Http\Requests\Quote;

use App\Enums\QuoteStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

final class UpdateQuoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_id' => 'required|exists:clients,id',
            'valid_until' => 'required|date',
            'status' => ['nullable', new Enum(QuoteStatus::class)],
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'nullable|exists:products,id',
            'items.*.service_id' => 'nullable|exists:services,id',
            'items.*.description' => 'required|string|max:255',
            'items.*.quantity' => 'required|numeric|min:0.0001',
            'items.*.unit_price' => 'required|numeric|min:0',
            'items.*.discount' => 'nullable|numeric|min:0',
        ];
    }

    public function withValidator($validator): void
    {
        $validator->after(function ($validator) {
            foreach ((array) $this->input('items', []) as $index => $item) {
                $hasProduct = !empty($item['product_id']);
                $hasService = !empty($item['service_id']);

                if ($hasProduct && $hasService) {
                    $validator->errors()->add("items.{$index}", 'Cada item deve referenciar produto ou serviço, nunca ambos.');
                }
            }
        });
    }
}
