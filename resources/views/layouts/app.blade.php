<!doctype html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>{{ $title ?? 'النخبة التعليمية' }}</title>
    <style>
        :root{font-family:Tahoma,Arial,sans-serif;color:#241432;background:#fffaf6}*{box-sizing:border-box}body{margin:0}a{color:#d94d31;text-decoration:none}.shell{max-width:1100px;margin:auto;padding:28px 18px}.nav{display:flex;justify-content:space-between;align-items:center;margin-bottom:32px}.brand{font-weight:800;color:#2e1a47}.nav-actions{display:flex;gap:14px;align-items:center;font-size:13px}.button{display:inline-block;border:0;border-radius:10px;background:#ff6b4a;color:#fff;padding:11px 16px;font:700 13px Tahoma;cursor:pointer}.panel{background:#fff;border:1px solid #eadfeb;border-radius:16px;padding:22px;box-shadow:0 12px 30px #2915400d}.grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:14px}.field{display:grid;gap:6px;margin-bottom:13px;font-size:13px;font-weight:700}.field input{border:1px solid #eadfeb;border-radius:9px;padding:11px;font:inherit}.alert{padding:10px 12px;border-radius:9px;background:#fff0f0;color:#b52e3e;font-size:13px}.success{background:#e8f8ef;color:#17734d}.muted{color:#756882;font-size:13px}
    </style>
</head>
<body>
@include('partials.site-nav')
<main class="shell">
    @if(session('success'))<p class="alert success">{{ session('success') }}</p>@endif
    @if($errors->any())<div class="alert">{{ $errors->first() }}</div>@endif
    @yield('content')
</main>
</body>
</html>