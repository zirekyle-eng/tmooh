@extends('layouts.app', ['title' => 'إنشاء حساب'])
@section('content')
<section class="panel" style="max-width:620px;margin:30px auto">
    <h1>إنشاء حساب طالب</h1>
    <p class="muted">أنشئ حسابك للوصول إلى المواد التعليمية.</p>
    <form method="post" action="{{ route('register.store') }}">
        @csrf
        <label class="field">الاسم الكامل<input name="full_name" value="{{ old('full_name') }}" required></label>
        <label class="field">رقم الجوال<input name="phone" type="tel" value="{{ old('phone') }}" required></label>
        <label class="field">كلمة المرور<input name="password" type="password" minlength="8" required></label>
        <div class="grid"><label class="field">الدولة<input name="country" value="{{ old('country', 'فلسطين') }}"></label><label class="field">المدينة<input name="city" value="{{ old('city') }}"></label></div>
        <button class="button">إنشاء الحساب</button>
    </form>
</section>
@endsection