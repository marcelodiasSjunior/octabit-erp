<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Quote\StoreQuoteRequest;
use App\Http\Requests\Quote\UpdateQuoteRequest;
use App\Services\QuoteService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

final class QuoteController extends Controller
{
    public function __construct(
        private readonly QuoteService $service
    ) {}

    public function index(Request $request): JsonResponse
    {
        $quotes = $this->service->list(
            filters: $request->only(['status', 'search', 'client_id']),
            perPage: (int) $request->integer('per_page', 15)
        );

        return response()->json($quotes);
    }

    public function store(StoreQuoteRequest $request): JsonResponse
    {
        $quote = $this->service->create($request->validated());

        return response()->json($quote, Response::HTTP_CREATED);
    }

    public function show(int $id): JsonResponse
    {
        return response()->json($this->service->findOrFail($id));
    }

    public function update(UpdateQuoteRequest $request, int $id): JsonResponse
    {
        $quote = $this->service->update($id, $request->validated());

        return response()->json($quote);
    }

    public function destroy(int $id): JsonResponse
    {
        $this->service->delete($id);

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }

    public function markAsSent(int $id): JsonResponse
    {
        return response()->json($this->service->markAsSent($id));
    }

    public function approve(int $id): JsonResponse
    {
        return response()->json($this->service->approve($id));
    }

    public function reject(int $id): JsonResponse
    {
        return response()->json($this->service->reject($id));
    }

    public function convertToSale(int $id): JsonResponse
    {
        return response()->json($this->service->convertToSale($id));
    }

    public function pdf(int $id)
    {
        $quote = $this->service->findOrFail($id);

        // Graceful fallback when dompdf is not installed yet.
        if (!app()->bound('dompdf.wrapper')) {
            return response()->view('pdf.quotes.show', [
                'quote' => $quote,
            ]);
        }

        $pdf = app('dompdf.wrapper');
        $pdf->loadView('pdf.quotes.show', [
            'quote' => $quote,
        ]);

        return $pdf->download("orcamento-{$quote->id}.pdf");
    }
}
