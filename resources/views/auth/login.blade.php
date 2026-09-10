@extends('layouts.app', ['title' => 'تسجيل الدخول'])
@section('content')
<section class="panel" style="max-width:520px;margin:50px auto">
    <h1>تسجيل الدخول</h1>
    <p class="muted">ادخل إلى حسابك لمتابعة المواد والجدول الدراسي.</p>
    <form method="post" action="{{ route('login.store') }}">
        @csrf
        <label class="field">رقم الجوال<input name="phone" type="tel" value="{{ old('phone') }}" required></label>
        <label class="field">كلمة المرور<input name="password" type="password" required></label>
        <button class="button">دخول</button>
    </form>
    <p class="muted">ليس لديك حساب؟ <a href="{{ route('register') }}">إنشاء حساب طالب</a></p>
</section>
@endsection