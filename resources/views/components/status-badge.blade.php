@props(['status'])

@php
    use App\Enums\ClientStatus;
    use App\Enums\PaymentStatus;
    use App\Enums\ContractStatus;
    use App\Enums\QuoteStatus;

    if ($status instanceof ClientStatus) {
        $label = $status->label();
        $color = match($status) {
            ClientStatus::Active   => 'text-emerald-400 bg-emerald-500/10 border-emerald-500/20',
            ClientStatus::Lead     => 'text-blue-400 bg-blue-500/10 border-blue-500/20',
            ClientStatus::Inactive => 'text-yellow-400 bg-yellow-500/10 border-yellow-500/20',
            ClientStatus::Canceled => 'text-red-400 bg-red-500/10 border-red-500/20',
        };
    } elseif ($status instanceof QuoteStatus) {
        $label = $status->label();
        $color = match($status) {
            QuoteStatus::Draft    => 'text-slate-400 bg-slate-500/10 border-slate-500/20',
            QuoteStatus::Sent     => 'text-blue-400 bg-blue-500/10 border-blue-500/20',
            QuoteStatus::Approved => 'text-emerald-400 bg-emerald-500/10 border-emerald-500/20',
            QuoteStatus::Rejected => 'text-red-400 bg-red-500/10 border-red-500/20',
        };
    } elseif ($status instanceof PaymentStatus) {
        $label = $status->label();
        $color = match($status) {
            PaymentStatus::Paid     => 'text-emerald-400 bg-emerald-500/10 border-emerald-500/20',
            PaymentStatus::Pending  => 'text-yellow-400 bg-yellow-500/10 border-yellow-500/20',
            PaymentStatus::Overdue  => 'text-red-400 bg-red-500/10 border-red-500/20',
            PaymentStatus::Canceled => 'text-slate-400 bg-slate-500/10 border-slate-500/20',
        };
    } elseif ($status instanceof ContractStatus) {
        $label = $status->label();
        $color = match($status) {
            ContractStatus::Active   => 'text-emerald-400 bg-emerald-500/10 border-emerald-500/20',
            ContractStatus::Draft    => 'text-slate-400 bg-slate-500/10 border-slate-500/20',
            ContractStatus::Expired  => 'text-yellow-400 bg-yellow-500/10 border-yellow-500/20',
            ContractStatus::Canceled => 'text-red-400 bg-red-500/10 border-red-500/20',
        };
    } else {
        $label = $status instanceof \UnitEnum ? ($status->label() ?? $status->name) : (string) $status;
        $color = 'text-slate-400 bg-slate-500/10 border-slate-500/20';
    }
@endphp

<span class="badge border {{ $color }}">{{ $label }}</span>
