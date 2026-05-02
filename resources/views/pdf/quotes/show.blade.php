<!doctype html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Orçamento #{{ $quote->id }} - OctaBit</title>
    <style>
        @page { margin: 1cm; }
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            font-size: 11px; 
            color: #334155; 
            line-height: 1.5;
        }
        .header { 
            border-bottom: 2px solid #7c3aed; 
            padding-bottom: 20px; 
            margin-bottom: 30px; 
        }
        .company-info { float: left; width: 50%; }
        .quote-info { float: right; width: 50%; text-align: right; }
        .clear { clear: both; }
        .company-name { 
            font-size: 24px; 
            font-weight: bold; 
            color: #7c3aed; 
            margin-bottom: 5px;
        }
        .quote-title { 
            font-size: 18px; 
            font-weight: bold; 
            color: #1e293b;
            margin-bottom: 5px;
        }
        .section-title {
            background: #f8fafc;
            padding: 8px 12px;
            font-weight: bold;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 15px;
            border-left: 4px solid #7c3aed;
        }
        .client-info { margin-bottom: 30px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { 
            background: #f1f5f9; 
            color: #475569; 
            text-align: left; 
            padding: 10px; 
            border-bottom: 2px solid #e2e8f0;
            text-transform: uppercase;
            font-size: 10px;
        }
        td { padding: 10px; border-bottom: 1px solid #f1f5f9; }
        .text-right { text-align: right; }
        .totals-container { margin-top: 30px; }
        .totals-table { width: 250px; margin-left: auto; }
        .totals-table td { border: none; padding: 5px 0; }
        .total-row { 
            font-size: 14px; 
            font-weight: bold; 
            color: #7c3aed; 
            border-top: 2px solid #e2e8f0 !important;
        }
        .footer { 
            position: fixed; 
            bottom: 0; 
            width: 100%; 
            text-align: center; 
            color: #94a3b8; 
            font-size: 9px;
            border-top: 1px solid #f1f5f9;
            padding-top: 10px;
        }
        .status-badge {
            display: inline-block;
            padding: 2px 8px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 9px;
            text-transform: uppercase;
        }
        .status-approved { background: #dcfce7; color: #166534; }
        .status-rejected { background: #fee2e2; color: #991b1b; }
        .status-sent { background: #dbeafe; color: #1e40af; }
        .status-draft { background: #f1f5f9; color: #475569; }
    </style>
</head>
<body>
    <div class="header">
        <div class="company-info">
            <div class="company-name">OctaBit</div>
            <div>Soluções em Tecnologia e Gestão</div>
            <div class="muted">contato@octabit.tech</div>
        </div>
        <div class="quote-info">
            <div class="quote-title">ORÇAMENTO #{{ $quote->id }}</div>
            <div>Data: {{ $quote->created_at->format('d/m/Y') }}</div>
            @if($quote->valid_until)
                <div>Válido até: {{ $quote->valid_until->format('d/m/Y') }}</div>
            @endif
            <div style="margin-top: 5px;">
                <span class="status-badge status-{{ $quote->status->value }}">
                    {{ $quote->status->label() }}
                </span>
            </div>
        </div>
        <div class="clear"></div>
    </div>

    <div class="client-info">
        <div class="section-title">Informações do Cliente</div>
        <div style="padding-left: 12px;">
            <div style="font-size: 14px; font-weight: bold; color: #1e293b;">{{ $quote->client->display_name }}</div>
            @if($quote->client->document)
                <div>Doc: {{ $quote->client->formatted_document }}</div>
            @endif
            @if($quote->client->email)
                <div>E-mail: {{ $quote->client->email }}</div>
            @endif
            @if($quote->client->phone)
                <div>Telefone: {{ $quote->client->phone }}</div>
            @endif
        </div>
    </div>

    <div class="section-title">Itens do Orçamento</div>
    <table>
        <thead>
            <tr>
                <th width="45%">Descrição</th>
                <th class="text-right">Qtd</th>
                <th class="text-right">Vlr. Unitário</th>
                <th class="text-right">Desc.</th>
                <th class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quote->items as $item)
                <tr>
                    <td>{{ $item->description }}</td>
                    <td class="text-right">{{ number_format((float) $item->quantity, 2, ',', '.') }}</td>
                    <td class="text-right">R$ {{ number_format((float) $item->unit_price, 2, ',', '.') }}</td>
                    <td class="text-right">{{ $item->discount > 0 ? number_format((float)$item->discount, 1, ',', '.') . '%' : '0%' }}</td>
                    <td class="text-right">R$ {{ number_format((float) $item->line_total, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="totals-container">
        <table class="totals-table">
            <tr>
                <td class="text-right">Subtotal:</td>
                <td class="text-right w-32">R$ {{ number_format((float) $quote->subtotal, 2, ',', '.') }}</td>
            </tr>
            @if($quote->discount_total > 0)
                <tr>
                    <td class="text-right" style="color: #ef4444;">Descontos:</td>
                    <td class="text-right" style="color: #ef4444;">- R$ {{ number_format((float) $quote->discount_total, 2, ',', '.') }}</td>
                </tr>
            @endif
            <tr class="total-row">
                <td class="text-right">VALOR TOTAL:</td>
                <td class="text-right">R$ {{ number_format((float) $quote->total, 2, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    @if($quote->notes)
        <div style="margin-top: 40px;">
            <div class="section-title">Observações</div>
            <div style="padding: 0 12px; color: #64748b;">
                {!! nl2br(e($quote->notes)) !!}
            </div>
        </div>
    @endif

    <div class="footer">
        OctaBit ERP - Gerado em {{ date('d/m/Y H:i') }} - octabit.tech
    </div>
</body>
</html>
