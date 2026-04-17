<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Orcamento #{{ $quote->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; color: #1f2937; }
        .header { margin-bottom: 18px; }
        .title { font-size: 20px; font-weight: bold; margin-bottom: 8px; }
        .muted { color: #6b7280; }
        table { width: 100%; border-collapse: collapse; margin-top: 12px; }
        th, td { border: 1px solid #e5e7eb; padding: 6px; text-align: left; }
        th { background: #f3f4f6; }
        .totals { margin-top: 14px; width: 280px; margin-left: auto; }
        .totals td { border: none; padding: 4px 0; }
        .totals .label { text-align: right; padding-right: 10px; }
        .totals .value { text-align: right; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Orcamento #{{ $quote->id }}</div>
        <div>Cliente: {{ $quote->client->display_name }}</div>
        <div class="muted">Valido ate: {{ $quote->valid_until?->format('d/m/Y') }}</div>
        <div class="muted">Status: {{ $quote->status->label() }}</div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Descricao</th>
                <th>Qtd</th>
                <th>Vlr Unitario</th>
                <th>Desconto</th>
                <th>Total Item</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quote->items as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td>{{ number_format((float) $item->quantity, 2, ',', '.') }}</td>
                    <td>R$ {{ number_format((float) $item->unit_price, 2, ',', '.') }}</td>
                    <td>R$ {{ number_format((float) $item->discount, 2, ',', '.') }}</td>
                    <td>R$ {{ number_format((float) $item->line_total, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <table class="totals">
        <tr>
            <td class="label">Subtotal</td>
            <td class="value">R$ {{ number_format((float) $quote->subtotal, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="label">Descontos</td>
            <td class="value">R$ {{ number_format((float) $quote->discount_total, 2, ',', '.') }}</td>
        </tr>
        <tr>
            <td class="label">Total</td>
            <td class="value">R$ {{ number_format((float) $quote->total, 2, ',', '.') }}</td>
        </tr>
    </table>
</body>
</html>
