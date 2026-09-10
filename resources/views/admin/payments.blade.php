@extends('layouts.admin', ['title' => 'الدفعات'])

@section('content')
<style>
    .payments-head { display:flex; justify-content:space-between; align-items:end; gap:18px; margin-bottom:20px; }
    .payments-head h1 { margin:0; }
    .payments-head p { margin:5px 0 0; }
    .payment-stats { display:grid; grid-template-columns:repeat(3, 1fr); gap:13px; margin:20px 0; }
    .payment-stat { display:block; padding:17px; background:#fff; border:1px solid var(--line); border-radius:15px; color:var(--ink); text-decoration:none; }
    .payment-stat strong { display:block; font-size:25px; }
    .payment-stat small { color:var(--muted); font-size:11px; }
    .payment-stat.pending { border-top:4px solid #f59e0b; }
    .payment-stat.approved { border-top:4px solid var(--mint); }
    .payment-stat.rejected { border-top:4px solid #e14f2e; }
    .payment-stat.active { box-shadow:0 8px 20px rgba(46,26,71,.12); }
    .payment-tabs { display:flex; gap:8px; flex-wrap:wrap; margin-bottom:18px; }
    .payment-tabs a { border:1px solid var(--line); border-radius:99px; padding:8px 12px; text-decoration:none; color:var(--muted); font-size:11px; }
    .payment-tabs a.active { background:var(--p); color:#fff; border-color:var(--p); }
    .payment-row { display:grid; grid-template-columns:60px 1fr auto; gap:15px; align-items:center; padding:14px 0; border-bottom:1px solid #eef0f5; }
    .payment-row:last-child { border-bottom:0; }
    .receipt { width:58px; height:58px; border-radius:10px; object-fit:cover; border:1px solid var(--line); }
    .receipt-empty { width:58px; height:58px; display:grid; place-items:center; background:#f5f3ff; border-radius:10px; color:#6d4fd0; font-size:10px; }
    .payment-details strong, .payment-details small { display:block; }
    .payment-details strong { font-size:13px; }
    .payment-details small { margin-top:4px; color:var(--muted); font-size:11px; }
    .payment-result { text-align:left; min-width:125px; }
    .payment-amount { display:block; color:#e14f2e; font-weight:800; font-size:13px; }
    .status-badge { display:inline-block; margin-top:5px; padding:4px 7px; border-radius:99px; font-size:9px; font-weight:800; }
    .status-badge.pending { background:#fff4d8; color:#a16207; }
    .status-badge.approved { background:#dcfce7; color:#166534; }
    .status-badge.rejected { background:#fee2e2; color:#b91c1c; }
    .payment-actions { display:flex; gap:5px; margin-top:7px; }
    .payment-actions button { border:0; border-radius:7px; padding:6px 8px; font:700 10px Tajawal; cursor:pointer; }
    .approve { background:var(--mint); color:#fff; }
    .reject { background:#fff1f2; color:#b91c1c; }
    .empty-payments { color:var(--muted); font-size:12px; }
    @media(max-width:600px) {
        .payment-stats { grid-template-columns:1fr; }
        .payment-row { grid-template-columns:55px 1fr; }
        .payment-result { grid-column:1/-1; text-align:right; }
    }
</style>

<header class="payments-head">
    <div>
        <h1>كل الدفعات</h1>
        <p class="muted">راجع إشعارات الدفع واعتمد التسجيل لتفعيل المادة للطالب.</p>
    </div>
</header>

<div class="payment-stats">
    @foreach(['pending' => 'قيد المراجعة', 'approved' => 'تم اعتمادها', 'rejected' => 'تم رفضها'] as $status => $label)
        <a class="payment-stat {{ $status }} {{ $filter === $status ? 'active' : '' }}" href="{{ route('admin.payments', ['status' => $status]) }}">
            <strong>{{ $counts[$status] }}</strong>
            <small>{{ $label }}</small>
        </a>
    @endforeach
</div>

@if(session('success'))<p class="alert success">{{ session('success') }}</p>@endif

<section class="panel">
    <nav class="payment-tabs">
        <a class="{{ $filter === null ? 'active' : '' }}" href="{{ route('admin.payments') }}">الكل</a>
        <a class="{{ $filter === 'pending' ? 'active' : '' }}" href="{{ route('admin.payments', ['status' => 'pending']) }}">قيد المراجعة</a>
        <a class="{{ $filter === 'approved' ? 'active' : '' }}" href="{{ route('admin.payments', ['status' => 'approved']) }}">المعتمدة</a>
        <a class="{{ $filter === 'rejected' ? 'active' : '' }}" href="{{ route('admin.payments', ['status' => 'rejected']) }}">المرفوضة</a>
    </nav>

    @forelse($payments as $payment)
        <article class="payment-row">
            @if($payment->receipt_path)
                <a href="{{ asset($payment->receipt_path) }}" target="_blank" rel="noopener">
                    <img class="receipt" src="{{ asset($payment->receipt_path) }}" alt="إشعار الدفع">
                </a>
            @else
                <div class="receipt-empty">بدون إيصال</div>
            @endif
            <div class="payment-details">
                <strong>{{ $payment->full_name }} · {{ $payment->subject_name ?: 'رسوم تسجيل' }}</strong>
                <small>{{ $payment->phone ?: 'بدون هاتف' }} · {{ $payment->method ?: 'غير محدد' }} · {{ $payment->created_at ? \Carbon\Carbon::parse($payment->created_at)->format('Y/m/d') : 'بدون تاريخ' }}</small>
            </div>
            <div class="payment-result">
                <span class="payment-amount">{{ number_format((float) $payment->amount, 2) }} ₪</span>
                <span class="status-badge {{ $payment->status }}">{{ ['pending' => 'قيد المراجعة', 'approved' => 'معتمدة', 'rejected' => 'مرفوضة'][$payment->status] ?? $payment->status }}</span>
                @if($payment->status === 'pending')
                    <div class="payment-actions">
                        <form method="post" action="{{ route('admin.payments.update') }}">@csrf<input type="hidden" name="payment_id" value="{{ $payment->id }}"><input type="hidden" name="action" value="approve"><button class="approve" type="submit">اعتماد</button></form>
                        <form method="post" action="{{ route('admin.payments.update') }}">@csrf<input type="hidden" name="payment_id" value="{{ $payment->id }}"><input type="hidden" name="action" value="reject"><button class="reject" type="submit">رفض</button></form>
                    </div>
                @endif
            </div>
        </article>
    @empty
        <p class="empty-payments">لا توجد دفعات بهذه الحالة.</p>
    @endforelse
</section>
@endsection
