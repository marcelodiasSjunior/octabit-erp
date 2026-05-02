<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Orçamentos - OctaBit</title>
    <style>
        @page { margin: 1cm; }
        body { font-family: 'Helvetica', sans-serif; font-size: 10px; color: #334155; line-height: 1.4; }
        .header { border-bottom: 2px solid #7c3aed; padding-bottom: 10px; margin-bottom: 20px; }
        .title { font-size: 18px; font-weight: bold; color: #1e293b; }
        .subtitle { font-size: 12px; color: #64748b; }
        .summary-grid { margin-bottom: 25px; width: 100%; }
        .summary-card { 
            background: #f8fafc; 
            padding: 10px; 
            border: 1px solid #e2e8f0; 
            border-radius: 4px;
            width: 23%;
            display: inline-block;
            margin-right: 1%;
            text-align: center;
        }
        .summary-label { font-size: 8px; text-transform: uppercase; color: #64748b; margin-bottom: 5px; }
        .summary-value { font-size: 14px; font-weight: bold; color: #1e293b; }
        .section-title {
            background: #f1f5f9;
            padding: 6px 10px;
            font-weight: bold;
            color: #475569;
            margin-top: 20px;
            margin-bottom: 10px;
            border-left: 3px solid #7c3aed;
        }
        table { width: 100%; border-collapse: collapse; }
        th { background: #f8fafc; text-align: left; padding: 8px; border-bottom: 1px solid #e2e8f0; font-size: 9px; }
        td { padding: 8px; border-bottom: 1px dotted #e2e8f0; }
        .text-right { text-align: right; }
        .text-emerald { color: #166534; }
        .text-red { color: #991b1b; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; color: #94a3b8; font-size: 8px; border-top: 1px solid #f1f5f9; padding-top: 5px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Relatório de Orçamentos</div>
        <div class="subtitle">Período: {{ \Carbon\Carbon::parse($filters['start_date'])->format('d/m/Y') }} a {{ \Carbon\Carbon::parse($filters['end_date'])->format('d/m/Y') }}</div>
    </div>

    <div class="summary-grid">
        <div class="summary-card">
            <div class="summary-label">Total Orçamentos</div>
            <div class="summary-value">{{ $summary['total_count'] }}</div>
        </div>
        <div class="summary-card">
            <div class="summary-label">Taxa Conversão</div>
            <div class="summary-value text-emerald">{{ number_format($summary['conversion_rate'], 1, ',', '.') }}%</div>
        </div>
        <div class="summary-card">
            <div class="summary-label">Valor Aprovado</div>
            <div class="summary-value text-emerald">R$ {{ number_format($summary['total_value_approved'], 2, ',', '.') }}</div>
        </div>
        <div class="summary-card">
            <div class="summary-label">Valor Rejeitado</div>
            <div class="summary-value text-red">R$ {{ number_format($summary['total_value_rejected'], 2, ',', '.') }}</div>
        </div>
    </div>

    <div class="section-title">Listagem Detalhada</div>
    <table>
        <thead>
            <tr>
                <th>Data</th>
                <th>Cliente</th>
                <th class="text-right">Total</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quotes as $quote)
                <tr>
                    <td>{{ $quote->created_at->format('d/m/Y') }}</td>
                    <td>{{ $quote->client->display_name }}</td>
                    <td class="text-right">R$ {{ number_format($quote->total, 2, ',', '.') }}</td>
                    <td>{{ $quote->status->label() }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        OctaBit ERP - Gerado em {{ date('d/m/Y H:i') }}
    </div>
</body>
</html>
