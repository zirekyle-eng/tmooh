<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ $title ?? 'لوحة الإدارة' }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+Bhaijaan+2:wght@400;600;700;800&family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">
    <style>
        :root{--p:#2e1a47;--c:#ff6b4a;--cd:#e14f2e;--m:#22a66b;--s:#ffc857;--paper:#fffdfa;--ink:#241432;--muted:#736686;--line:#efe3f1}*{box-sizing:border-box}body{margin:0;background:#faf7fb;color:var(--ink);font-family:Tajawal,sans-serif}.admin-shell{min-height:100vh;display:flex;background:#faf7fb}.admin-sidebar{width:250px;flex:none;background:var(--p);color:#fff;padding:26px 17px;display:flex;flex-direction:column}.admin-top{display:flex;align-items:center;justify-content:space-between;gap:12px;margin-bottom:18px}.admin-logo{display:flex;align-items:center;gap:10px;color:#fff;text-decoration:none;font:700 19px 'Baloo Bhaijaan 2',Tajawal,sans-serif}.admin-logo b{display:grid;place-items:center;width:39px;height:39px;background:var(--c);border-radius:13px 13px 13px 4px}.admin-logo small{display:block;color:#cdbfdb;font:11px Tajawal,sans-serif;font-weight:400}.notification-bell{display:inline-flex;align-items:center;gap:8px;color:#fff;text-decoration:none;font:700 13px Tajawal;position:relative}.notification-bell span:first-child{font-size:18px}.notification-count{min-width:22px;height:22px;border-radius:999px;background:var(--c);color:#fff;display:inline-flex;align-items:center;justify-content:center;font-size:11px;font-weight:800;padding:0 8px}.admin-nav{display:grid;gap:6px}.admin-nav a{padding:12px 13px;border-radius:11px;color:#d9cbe8;text-decoration:none;font:700 13px Tajawal}.admin-nav a span{display:inline-block;width:24px}.admin-nav a:hover,.admin-nav a.active{background:#ffffff18;color:#fff}.admin-nav a.moodle{background:var(--s);color:var(--p);margin-top:8px;text-align:center}.admin-exit{margin-top:auto;padding:12px 13px;color:#ffc5b8;text-decoration:none;font:700 13px Tajawal;background:none;border:0;cursor:pointer;text-align:right}.admin-content{min-width:0;flex:1;padding:30px 38px}.admin-content h1,.admin-content h2{font-family:'Baloo Bhaijaan 2',Tajawal,sans-serif}.panel{background:#fff;border:1px solid var(--line);border-radius:18px;padding:22px;box-shadow:0 12px 28px #2e1a4708}.grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:16px}.button{display:inline-block;border:0;border-radius:11px;background:var(--c);color:#fff;padding:11px 16px;font:800 12px Tajawal;cursor:pointer;text-decoration:none}.muted{color:var(--muted);font-size:12px}.alert{padding:11px 13px;border-radius:10px;background:#fff0f0;color:#b52e3e;font-size:12px;margin:0 0 16px}.success{background:#e7f8ee;color:#177349}.admin-menu-toggle{display:none}@media(max-width:900px){.admin-sidebar{width:68px;padding:20px 10px}.admin-logo span,.admin-nav a:not(.active){font-size:0}.admin-logo b{margin:auto}.admin-top{display:block}.notification-bell{display:flex;margin:18px auto}.admin-nav a{height:44px;padding:0;display:grid;place-items:center}.admin-nav a span{width:auto;font-size:19px}.admin-nav a.moodle{font-size:0}.admin-exit{font-size:0;text-align:center;padding:12px 0}.admin-exit:before{content:'↩';font-size:20px}.admin-content{padding:24px 18px}}@media(max-width:520px){.admin-sidebar{width:58px;padding:18px 7px}.admin-content{padding:20px 12px}}
        .admin-content>h1{font:700 31px 'Baloo Bhaijaan 2',Tajawal,sans-serif;margin:0 0 5px}.admin-content>p.muted{margin:0 0 24px}.admin-content h2{font:700 20px 'Baloo Bhaijaan 2',Tajawal,sans-serif}.admin-content h3{font:700 16px 'Baloo Bhaijaan 2',Tajawal,sans-serif}.admin-content label{font-size:12px;font-weight:800;color:var(--ink)}.admin-content input,.admin-content select,.admin-content textarea{font:12px Tajawal,sans-serif;color:var(--ink);background:#fffdfa;border:1px solid var(--line);border-radius:10px;padding:11px 12px}.admin-content input:focus,.admin-content select:focus,.admin-content textarea:focus{outline:2px solid #ffb5a5;border-color:var(--c)}.admin-content table{width:100%;border-collapse:collapse}.admin-content th{color:var(--muted);font-size:11px;font-weight:800}.admin-content th,.admin-content td{padding:13px 10px;border-bottom:1px solid #f0e9f2;text-align:right;font-size:12px}.admin-content article{transition:transform .2s,box-shadow .2s}.admin-content article:hover{transform:translateY(-2px);box-shadow:0 14px 28px #2e1a4712}.admin-content .grid>.panel,.admin-content .grid>article{min-width:0}.admin-content .tabs{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:16px}.admin-content .tabs a{border:1px solid var(--line);border-radius:99px;padding:8px 13px;color:var(--muted);font-size:11px;text-decoration:none}.admin-content .tabs a.active{background:var(--p);color:#fff;border-color:var(--p)}
    </style>
</head>
<body>
<div class="admin-shell">
    <aside class="admin-sidebar">
        <div class="admin-top">
            <a class="admin-logo" href="{{ route('admin.dashboard') }}"><b>ن</b><span>مدرسة طموح الإلكترونية<small>لوحة الإدارة</small></span></a>
            <a class="notification-bell" href="{{ route('admin.notifications') }}" title="الإشعارات"><span>🔔</span>@if(isset($unread) && $unread > 0)<span class="notification-count">{{ $unread }}</span>@endif</a>
        </div>
        <nav class="admin-nav">
            <a class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><span>◈</span>الرئيسية</a>
            <a class="{{ request()->routeIs('admin.academics*') ? 'active' : '' }}" href="{{ route('admin.academics') }}"><span>▣</span>الصفوف والمواد</a>
            <a class="{{ request()->routeIs('admin.payments*') ? 'active' : '' }}" href="{{ route('admin.payments') }}"><span>◉</span>الدفعات</a>
            <a class="{{ request()->routeIs('admin.schedule') ? 'active' : '' }}" href="{{ route('admin.schedule') }}"><span>◷</span>الجدول والغرف الدراسية</a>
            <a class="{{ request()->routeIs('admin.teachers') ? 'active' : '' }}" href="{{ route('admin.teachers') }}"><span>♙</span>المدرسون</a>
            <a class="{{ request()->routeIs('admin.applications') ? 'active' : '' }}" href="{{ route('admin.applications') }}"><span>✉</span>طلبات المدرسين</a>
            <a class="{{ request()->routeIs('admin.students') ? 'active' : '' }}" href="{{ route('admin.students') }}"><span>◌</span>الطلاب والتسجيلات</a>
            <a class="{{ request()->routeIs('admin.accounts') ? 'active' : '' }}" href="{{ route('admin.accounts') }}"><span>◉</span>الحسابات وكلمات المرور</a>
            <a class="moodle" href="{{ route('catalog') }}"><span>↗</span>الموقع العام</a>
        </nav>
        <form method="post" action="{{ route('logout') }}"><input type="hidden" name="_token" value="{{ csrf_token() }}"><button class="admin-exit" type="submit">↩ تسجيل الخروج</button></form>
    </aside>
    <main class="admin-content">
        @if(session('success'))<p class="alert success">{{ session('success') }}</p>@endif
        @if(isset($errors) && $errors->any())<p class="alert">{{ $errors->first() }}</p>@endif
        @yield('content')
    </main>
</div>
</body>
</html>