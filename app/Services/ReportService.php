<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\Contracts\AccountsPayableRepositoryInterface;
use App\Repositories\Contracts\AccountsReceivableRepositoryInterface;
use App\Repositories\Contracts\QuoteRepositoryInterface;
use App\Enums\PaymentStatus;
use App\Enums\QuoteStatus;
use Carbon\Carbon;

class ReportService
{
    public function __construct(
        private readonly AccountsReceivableRepositoryInterface $receivableRepository,
        private readonly AccountsPayableRepositoryInterface $payableRepository,
        private readonly QuoteRepositoryInterface $quoteRepository
    ) {}

    public function getFinancialReportData(string $startDate, string $endDate, ?string $status = null): array
    {
        $receivables = $this->receivableRepository->getFinancialData($startDate, $endDate, $status);
        $payables = $this->payableRepository->getFinancialData($startDate, $endDate, $status);

        $summary = [
            'total_received'   => (float) $receivables->filter(fn($i) => $i->status === PaymentStatus::Paid)->sum('amount'),
            'total_receivable' => (float) $receivables->filter(fn($i) => in_array($i->status, [PaymentStatus::Pending, PaymentStatus::Overdue]))->sum('amount'),
            'total_paid'       => (float) $payables->filter(fn($i) => $i->status === PaymentStatus::Paid)->sum('amount'),
            'total_payable'    => (float) $payables->filter(fn($i) => in_array($i->status, [PaymentStatus::Pending, PaymentStatus::Overdue]))->sum('amount'),
        ];

        $summary['balance'] = $summary['total_received'] - $summary['total_paid'];

        // Monthly chart data
        $chartData = $this->getMonthlyFinancialData($startDate, $endDate);

        return [
            'summary'     => $summary,
            'receivables' => $receivables,
            'payables'    => $payables,
            'chartData'   => $chartData,
        ];
    }

    private function getMonthlyFinancialData(string $startDate, string $endDate): array
    {
        $months = [];
        $current = Carbon::parse($startDate)->startOfMonth();
        $end = Carbon::parse($endDate)->endOfMonth();

        while ($current <= $end) {
            $months[$current->format('Y-m')] = [
                'label'    => $current->translatedFormat('M/Y'),
                'received' => 0.0,
                'paid'     => 0.0,
            ];
            $current->addMonth();
        }

        $receivedMonthly = $this->receivableRepository->getMonthlyPaidTotal($startDate, $endDate);
        $paidMonthly = $this->payableRepository->getMonthlyPaidTotal($startDate, $endDate);

        foreach ($months as $key => &$data) {
            $data['received'] = (float) ($receivedMonthly[$key] ?? 0);
            $data['paid']     = (float) ($paidMonthly[$key] ?? 0);
        }

        return array_values($months);
    }

    public function getQuoteReportData(string $startDate, string $endDate, ?int $clientId = null): array
    {
        $quotes = $this->quoteRepository->getQuotesInRange($startDate, $endDate, $clientId);

        $totalCount    = $quotes->count();
        $approvedCount = $quotes->where('status', QuoteStatus::Approved)->count();
        $rejectedCount = $quotes->where('status', QuoteStatus::Rejected)->count();
        $pendingCount  = $quotes->whereIn('status', [QuoteStatus::Draft, QuoteStatus::Sent])->count();

        $summary = [
            'total_count'          => $totalCount,
            'approved_count'       => $approvedCount,
            'rejected_count'       => $rejectedCount,
            'pending_count'        => $pendingCount,
            'conversion_rate'      => $totalCount > 0 ? ($approvedCount / $totalCount) * 100 : 0,
            'total_value_approved' => (float) $quotes->where('status', QuoteStatus::Approved)->sum('total'),
            'total_value_rejected' => (float) $quotes->where('status', QuoteStatus::Rejected)->sum('total'),
        ];

        return [
            'summary' => $summary,
            'quotes'  => $quotes,
        ];
    }
}
