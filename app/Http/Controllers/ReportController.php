<?php

namespace App\Http\Controllers;

use App\Services\ReportService;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    protected $reportService;

    public function __construct(ReportService $reportService)
    {
        $this->reportService = $reportService;
    }

    public function financial(Request $request)
    {
        $start_date = $request->get('start_date', Carbon::now()->startOfMonth()->toDateString());
        $end_date = $request->get('end_date', Carbon::now()->endOfMonth()->toDateString());
        $status = $request->get('status');

        $data = $this->reportService->getFinancialReportData($start_date, $end_date, $status);

        return view('reports.financial', array_merge($data, [
            'filters' => [
                'start_date' => $start_date,
                'end_date' => $end_date,
                'status' => $status
            ]
        ]));
    }

    public function quotes(Request $request)
    {
        $start_date = $request->get('start_date', Carbon::now()->startOfMonth()->toDateString());
        $end_date = $request->get('end_date', Carbon::now()->endOfMonth()->toDateString());
        $client_id = $request->get('client_id');

        $data = $this->reportService->getQuoteReportData($start_date, $end_date, $client_id ? (int)$client_id : null);

        return view('reports.quotes', array_merge($data, [
            'filters' => [
                'start_date' => $start_date,
                'end_date' => $end_date,
                'client_id' => $client_id
            ]
        ]));
    }

    public function export(string $type, Request $request)
    {
        $start_date = $request->get('start_date', Carbon::now()->startOfMonth()->toDateString());
        $end_date = $request->get('end_date', Carbon::now()->endOfMonth()->toDateString());
        $format = $request->get('format', 'csv');

        if ($type === 'financial') {
            $data = $this->reportService->getFinancialReportData($start_date, $end_date, $request->get('status'));
            
            if ($format === 'pdf') {
                $pdf = app('dompdf.wrapper');
                $pdf->loadView('pdf.reports.financial', array_merge($data, [
                    'filters' => [
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                    ]
                ]));
                return $pdf->download("relatorio-financeiro-{$start_date}-a-{$end_date}.pdf");
            }

            $filename = "relatorio-financeiro-{$start_date}-a-{$end_date}.csv";
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            ];

            $callback = function() use ($data) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['Tipo', 'Data', 'Descricao/Cliente', 'Valor', 'Status']);

                foreach ($data['receivables'] as $item) {
                    fputcsv($file, ['Entrada', $item->due_date->format('Y-m-d'), $item->client?->display_name ?? '—', $item->amount, $item->status->label()]);
                }
                foreach ($data['payables'] as $item) {
                    fputcsv($file, ['Saida', $item->due_date->format('Y-m-d'), $item->description, $item->amount, $item->status->label()]);
                }
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        if ($type === 'quotes') {
            $data = $this->reportService->getQuoteReportData($start_date, $end_date, $request->get('client_id'));

            if ($format === 'pdf') {
                $pdf = app('dompdf.wrapper');
                $pdf->loadView('pdf.reports.quotes', array_merge($data, [
                    'filters' => [
                        'start_date' => $start_date,
                        'end_date' => $end_date,
                    ]
                ]));
                return $pdf->download("relatorio-orcamentos-{$start_date}-a-{$end_date}.pdf");
            }

            $filename = "relatorio-orcamentos-{$start_date}-a-{$end_date}.csv";
            $headers = [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            ];

            $callback = function() use ($data) {
                $file = fopen('php://output', 'w');
                fputcsv($file, ['Data', 'Cliente', 'Subtotal', 'Desconto', 'Total', 'Status']);

                foreach ($data['quotes'] as $quote) {
                    fputcsv($file, [$quote->created_at->format('Y-m-d'), $quote->client->display_name, $quote->subtotal, $quote->discount_total, $quote->total, $quote->status->label()]);
                }
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }

        return redirect()->back()->with('error', 'Tipo de exportação inválido.');
    }
}
