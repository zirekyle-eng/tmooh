@extends('layouts.app', ['title' => 'المواد'])
@section('content')
<h1>المواد المتاحة</h1><p class="muted">المواد الفعالة في المنصة.</p>
<section class="grid">@forelse($subjects as $subject)<article class="panel"><small class="muted">{{ $subject->grade?->name }}</small><h2>{{ $subject->name }}</h2><p class="muted">{{ $subject->description ?: 'مادة تعليمية متاحة للتسجيل.' }}</p><strong>{{ number_format((float)$subject->monthly_fee, 2) }}</strong><form method="post" action="{{ route('enrollments.store') }}" style="margin-top:14px">@csrf<input type="hidden" name="subject_id" value="{{ $subject->id }}"><button class="button">طلب التسجيل</button></form></article>@empty<p class="muted">لا توجد مواد متاحة حاليًا.</p>@endforelse</section>
@endsection