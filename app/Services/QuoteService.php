<?php

declare(strict_types=1);

namespace App\Services;

use App\DTOs\Quote\CreateQuoteDTO;
use App\DTOs\Quote\UpdateQuoteDTO;
use App\Enums\QuoteStatus;
use App\Models\Quote;
use App\Repositories\Contracts\QuoteRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

final class QuoteService
{
    public function __construct(
        private readonly QuoteRepositoryInterface $repository
    ) {}

    public function list(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        return $this->repository->paginateFiltered($filters, $perPage);
    }

    public function findOrFail(int $id): Quote
    {
        return $this->repository->findWithItemsOrFail($id);
    }

    public function create(CreateQuoteDTO $dto): Quote
    {
        return DB::transaction(function () use ($dto) {
            $calculation = $this->calculate($dto->items);

            $companyId = app(\App\Services\TenantManager::class)->getCompanyId();
            $nextNumber = (DB::table('quotes')
                ->where('company_id', $companyId)
                ->lockForUpdate()
                ->max('sequential_number') ?? 0) + 1;

            $quote = $this->repository->create([
                'company_id'        => $companyId,
                'sequential_number' => $nextNumber,
                'client_id'         => $dto->clientId,
                'status'            => QuoteStatus::Draft->value,
                'valid_until'       => $dto->validUntil,
                'subtotal'          => $calculation['subtotal'],
                'discount_total'    => $calculation['discount_total'],
                'total'             => $calculation['total'],
            ]);

            $quote->items()->createMany($calculation['items']);

            return $quote->fresh(['client', 'items']);
        });
    }

    public function update(int $id, UpdateQuoteDTO $dto): Quote
    {
        return DB::transaction(function () use ($id, $dto) {
            $quote       = $this->findOrFail($id);
            $calculation = $this->calculate($dto->items);

            $this->repository->update($id, [
                'client_id'      => $dto->clientId,
                'valid_until'    => $dto->validUntil,
                'subtotal'       => $calculation['subtotal'],
                'discount_total' => $calculation['discount_total'],
                'total'          => $calculation['total'],
            ]);

            $quote->items()->delete();
            $quote->items()->createMany($calculation['items']);

            return $this->findOrFail($id);
        });
    }

    public function delete(int $id): void
    {
        $this->repository->delete($id);
    }

    public function markAsSent(int $id): Quote
    {
        $quote = $this->findOrFail($id);
        $this->assertStatus($quote, [QuoteStatus::Draft], 'Apenas orçamento em rascunho pode ser enviado.');

        return $this->repository->update($id, ['status' => QuoteStatus::Sent->value]);
    }

    public function approve(int $id): Quote
    {
        $quote = $this->findOrFail($id);
        $this->assertStatus($quote, [QuoteStatus::Sent], 'Apenas orçamento enviado pode ser aprovado.');

        return $this->repository->update($id, ['status' => QuoteStatus::Approved->value]);
    }

    public function reject(int $id): Quote
    {
        $quote = $this->findOrFail($id);
        $this->assertStatus($quote, [QuoteStatus::Sent], 'Apenas orçamento enviado pode ser rejeitado.');

        return $this->repository->update($id, ['status' => QuoteStatus::Rejected->value]);
    }

    public function convertToSale(int $id): Quote
    {
        $quote = $this->findOrFail($id);

        if (!$quote->isConvertible()) {
            throw ValidationException::withMessages([
                'quote' => 'Somente orçamentos aprovados e não convertidos podem ser convertidos em venda.',
            ]);
        }

        return $this->repository->update($id, [
            'converted_to_sale_at' => now(),
        ]);
    }

    private function assertStatus(Quote $quote, array $allowed, string $message): void
    {
        if (!in_array($quote->status, $allowed, true)) {
            throw ValidationException::withMessages([
                'status' => $message,
            ]);
        }
    }

    /**
     * @param \App\DTOs\Quote\QuoteItemDTO[] $items
     */
    private function calculate(array $items): array
    {
        $subtotal      = 0.0;
        $discountTotal = 0.0;
        $preparedItems = [];

        foreach ($items as $item) {
            $lineSubtotal = round($item->quantity * $item->unitPrice, 2);
            $lineDiscount = min($item->discount, $lineSubtotal);
            $lineTotal    = round($lineSubtotal - $lineDiscount, 2);

            $subtotal      += $lineSubtotal;
            $discountTotal += $lineDiscount;

            $preparedItems[] = [
                'product_id'    => $item->productId,
                'service_id'    => $item->serviceId,
                'description'   => $item->description,
                'quantity'      => $item->quantity,
                'unit_price'    => $item->unitPrice,
                'discount'      => $lineDiscount,
                'line_subtotal' => $lineSubtotal,
                'line_total'    => $lineTotal,
            ];
        }

        $subtotal      = round($subtotal, 2);
        $discountTotal = round($discountTotal, 2);

        return [
            'subtotal'       => $subtotal,
            'discount_total' => $discountTotal,
            'total'          => round($subtotal - $discountTotal, 2),
            'items'          => $preparedItems,
        ];
    }
}
