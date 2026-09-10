<style>
    .site-nav{position:sticky;top:0;z-index:50;background:#fffdfaf2;backdrop-filter:blur(12px);border-bottom:1px solid #ebdfeb}
    .site-nav .nav-inner{width:min(1140px,calc(100% - 36px));min-height:72px;margin:auto;display:flex;align-items:center;justify-content:space-between;gap:18px}
    .site-nav .brand{display:flex;align-items:center;gap:10px;font-size:17px;font-weight:800;color:#241432;text-decoration:none}
    .site-nav .brand img{width:48px;height:48px;border-radius:14px;object-fit:cover}
    .site-nav .brand small{display:block;color:#71647d;font-size:10px;font-weight:500;margin-top:-3px}
    .site-nav .links{display:flex;align-items:center;gap:18px;font-size:12px}
    .site-nav .links a{font-size:12px;font-weight:700;color:#594b64;text-decoration:none;white-space:nowrap}
    .site-nav .links a:hover,.site-nav .links a.active{color:#f4674a}
    .site-nav .actions{display:flex;gap:9px;align-items:center}
    .site-nav .button{display:inline-block;border:0;border-radius:99px;padding:11px 19px;background:#f4674a;color:#fff;font:700 13px Cairo;cursor:pointer;transition:.2s;text-decoration:none}
    .site-nav .button:hover{transform:translateY(-2px);background:#df4e33}
    .site-nav .button.ghost{background:transparent;color:#241432}
    .site-nav .account-box{display:flex;align-items:center;gap:9px;padding:6px 7px 6px 6px;background:#fff;border:1px solid #e4e6e5;border-radius:999px;box-shadow:0 4px 14px rgba(36,20,50,.06)}
    .site-nav .account-avatar{width:34px;height:34px;display:grid;place-items:center;border-radius:50%;background:#2e1a47;color:#fff;font-size:12px;font-weight:800}
    .site-nav .account-link{padding:0 4px;color:#2e1a47;font-size:12px;font-weight:800;white-space:nowrap;text-decoration:none}
    .site-nav .account-link:hover{color:#f4674a}
    .site-nav .account-box .button{padding:8px 11px;border-radius:10px;background:#f4eef9;color:#2e1a47;font-size:11px}
    .site-nav .account-box .button:hover{background:#eadcf3;color:#2e1a47;transform:none}
    .site-nav .account-box .logout-button{background:#fff;color:#f4674a;border:1px solid #f0cfc7}
    .site-nav .mobile-account{display:none}
    .site-nav .menu-button{display:none;width:40px;height:40px;place-items:center;border:0;border-radius:12px;background:#2e1a47;color:#fff;font-size:21px;cursor:pointer}
    @media(max-width:900px){.site-nav .links{gap:13px}.site-nav .links a{font-size:12px}.site-nav .actions{gap:3px}.site-nav .button{padding:10px 12px}.site-nav .account-link{max-width:95px;overflow:hidden;text-overflow:ellipsis}.site-nav .account-box{gap:5px}.site-nav .account-box .button{padding:8px 9px}}
    @media(max-width:760px){.site-nav .nav-inner{min-height:68px}.site-nav .brand{font-size:16px}.site-nav .links{display:none;position:absolute;top:68px;right:18px;left:18px;padding:10px;background:#fff;border:1px solid #ebdfeb;border-radius:18px;box-shadow:0 20px 35px #21133d24}.site-nav .links.open{display:grid;gap:3px}.site-nav .links a{padding:10px 12px;border-radius:9px;font-size:13px}.site-nav .links a:hover{background:#fff0e9}.site-nav .mobile-account{display:block}.site-nav .mobile-account button{width:100%}.site-nav .actions{display:none}.site-nav .menu-button{display:grid}}
</style>
<header class="site-nav">
    @auth
        @php
            $dashboardRoute = match (auth()->user()->role) {
                'admin' => 'admin.dashboard',
                'teacher' => 'teacher.dashboard',
                default => 'dashboard',
            };
        @endphp
    @endauth
    <div class="nav-inner">
        <a class="brand" href="{{ route('home') }}"><img src="{{ asset('logo.jpeg') }}" alt="لوغو مدرسة طموح الإلكترونية"><span>مدرسة طموح الإلكترونية<small>لدروس التقوية</small></span></a>
        <nav class="links" id="main-menu">
            <a class="{{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">الرئيسية</a>
            <a class="{{ request()->routeIs('catalog') ? 'active' : '' }}" href="{{ route('catalog') }}">المواد</a>
            <a class="{{ request()->routeIs('pricing') ? 'active' : '' }}" href="{{ route('pricing') }}">الأسعار</a>
            <a class="{{ request()->routeIs('teachers*') ? 'active' : '' }}" href="{{ route('teachers') }}">المدرسون</a>
            <a class="{{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">من نحن</a>
            <a class="{{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">تواصل معنا</a>
            <a href="{{ route('contact') }}">انضم كمدرس</a>
            @auth
                <a class="mobile-account" href="{{ route($dashboardRoute) }}">الملف الشخصي: {{ auth()->user()->full_name }}</a>
                <form class="mobile-account" method="post" action="{{ route('logout') }}" style="margin:0">@csrf<button class="button" type="submit">تسجيل الخروج</button></form>
            @endauth
        </nav>
        <div class="actions">
            @auth
                <div class="account-box">
                    <a class="account-avatar" href="{{ route($dashboardRoute) }}" aria-label="لوحة التحكم">{{ mb_substr(auth()->user()->full_name, 0, 1) }}</a>
                    <a class="account-link" href="{{ route($dashboardRoute) }}">{{ auth()->user()->full_name }}</a>
                    <form method="post" action="{{ route('logout') }}" style="margin:0">@csrf<button class="button logout-button" type="submit">تسجيل الخروج</button></form>
                </div>
            @else
                <a class="button ghost" href="{{ route('login') }}">تسجيل الدخول</a><a class="button" href="{{ route('register') }}">إنشاء حساب</a>
            @endauth
        </div>
        <button class="menu-button" type="button" aria-label="فتح القائمة" aria-expanded="false" aria-controls="main-menu">☰</button>
    </div>
</header>
<script>
document.addEventListener('DOMContentLoaded',function(){var button=document.querySelector('.site-nav .menu-button'),menu=document.querySelector('.site-nav .links');if(!button||!menu)return;button.addEventListener('click',function(){var open=menu.classList.toggle('open');button.setAttribute('aria-expanded',String(open));button.textContent=open?'×':'☰';});menu.querySelectorAll('a').forEach(function(link){link.addEventListener('click',function(){menu.classList.remove('open');button.setAttribute('aria-expanded','false');button.textContent='☰';});});});
</script>