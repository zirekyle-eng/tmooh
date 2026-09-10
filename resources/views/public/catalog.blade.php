@extends('layouts.public', ['title' => 'المواد الدراسية'])
@section('content')

@php
    $allGrades = \App\Models\Grade::orderBy('id')->get();
    $markets = [
        1 => 'قطاع غزة',
        2 => 'الضفة الغربية',
        3 => 'مصر',
    ];
    $selectedMarketId = (int) request('market', 0);
    $selectedGradeId = (int) request('grade', 0);
    $filteredSubjects = $selectedMarketId
        ? $subjects->where('market_id', $selectedMarketId)->when($selectedGradeId, fn ($items) => $items->where('grade_id', $selectedGradeId))
        : collect();
@endphp

<style>
    .catalog-hero {
        background: var(--plum);
        color: #fff;
        padding: 62px 0 98px;
        position: relative;
        overflow: hidden;
        clip-path: polygon(0 0, 100% 0, 100% 91%, 0 100%);
    }
    
    .catalog-hero .container {
        position: relative;
        z-index: 1;
    }
    
    .catalog-hero p {
        max-width: 590px;
        color: #D9CBE8;
        line-height: 2;
    }
    
    .catalog-hero h1 {
        color: #fff;
        font-size: 44px;
        margin: 14px 0;
    }
    
    .catalog-hero em {
        color: var(--sun);
        font-style: normal;
    }
    
    .catalog-hero .orb {
        position: absolute;
        left: 8%;
        top: -65px;
        width: 250px;
        height: 250px;
        border-radius: 50%;
        background: var(--sun);
        opacity: 0.14;
    }
    
    .catalog-main {
        padding: 0 0 78px;
        margin-top: -26px;
        position: relative;
    }
    
    .tabs {
        display: flex;
        flex-wrap: wrap;
        gap: 9px;
        margin: 0 0 16px;
        padding: 20px;
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 24px;
        box-shadow: 0 24px 50px -34px rgba(46, 26, 71, 0.31);
    }

    .market-picker {
        max-width: 640px;
        margin: 0 auto 28px;
        padding: 28px;
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 24px;
        box-shadow: 0 24px 50px -34px rgba(46, 26, 71, 0.31);
    }

    .market-picker h2 {
        margin: 0 0 8px;
        color: var(--ink);
        font-size: 24px;
    }

    .market-picker p {
        margin: 0 0 22px;
        color: var(--muted);
        line-height: 1.9;
    }

    .market-options {
        display: grid;
        gap: 10px;
    }

    .market-option {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 14px 16px;
        border: 1px solid var(--line);
        border-radius: 14px;
        color: var(--ink);
        font-weight: 700;
        cursor: pointer;
    }

    .market-option:has(input:checked) {
        border-color: var(--coral);
        background: #fff7f4;
    }

    .market-option input {
        accent-color: var(--coral);
    }

    .market-picker .button {
        width: 100%;
        margin-top: 18px;
        opacity: .5;
    }

    .market-picker:has(input:checked) .button {
        opacity: 1;
    }
    
    .tabs a {
        padding: 9px 15px;
        border: 1px solid var(--line);
        background: #fff;
        border-radius: 999px;
        color: var(--ink);
        font-weight: 700;
        font-size: 13px;
        text-decoration: none;
        transition: all 0.2s ease;
        cursor: pointer;
    }
    
    .tabs a:hover {
        border-color: var(--coral);
        color: var(--coral);
    }
    
    .tabs a.active {
        background: var(--coral);
        color: #fff;
        border-color: var(--coral);
    }
    
    .catalog-note {
        color: var(--muted);
        font-size: 13px;
        margin: 25px 0;
    }
    
    .grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 20px;
    }
    
    .card {
        background: #fff;
        border: 1px solid var(--line);
        border-radius: 26px 26px 26px 6px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        transition: transform 0.15s ease;
    }
    
    .card:hover {
        transform: translateY(-5px) rotate(-0.5deg);
        box-shadow: 0 10px 30px rgba(46, 26, 71, 0.2);
    }
    
    .cover {
        height: 145px;
        background: linear-gradient(135deg, var(--coral), var(--plum-light));
        display: grid;
        place-items: center;
        color: #fff;
        font-size: 44px;
        font-weight: 800;
        position: relative;
    }
    
    .cover img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    
    .cover-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 100%;
        background: linear-gradient(135deg, var(--coral), var(--plum-light));
        font-size: 3.5rem;
        animation: float 3s ease-in-out infinite;
    }
    
    @keyframes float {
        0%, 100% {
            transform: translateY(0);
        }
        50% {
            transform: translateY(-10px);
        }
    }
    
    .card-copy {
        padding: 20px;
    }
    
    .card h2 {
        font-size: 19px;
        margin: 12px 0 7px;
        color: var(--ink);
    }
    
    .card p {
        color: var(--muted);
        font-size: 12px;
        line-height: 1.85;
        min-height: 48px;
    }
    
    .tag {
        display: inline-block;
        background: var(--mint-light);
        color: var(--mint);
        padding: 4px 9px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 800;
        text-decoration: none;
    }
    
    .card .button {
        display: block;
        margin-top: 15px;
        text-align: center;
        color: white;
        font-size: 12px;
        font-weight: 800;
        text-decoration: none;
        transition: all 0.2s ease;
        padding: 12px 16px;
        border-radius: 8px;
        border: none;
        cursor: pointer;
    }
    
    .card .button:hover {
        opacity: 0.9;
        box-shadow: 0 5px 15px rgba(255, 107, 74, 0.3);
    }
    
    .card .button:after {
        content: '';
    }
    
    .empty {
        grid-column: 1 / -1;
        text-align: center;
        padding: 45px;
        background: #fff;
        border: 1px dashed var(--line);
        border-radius: 18px;
        color: var(--muted);
    }
    
    @media (max-width: 780px) {
        .catalog-hero h1 {
            font-size: 34px;
        }
        
        .catalog-hero .orb {
            display: none;
        }
        
        .grid {
            grid-template-columns: 1fr;
        }
    }
</style>

<section class="catalog-hero">
    <div class="container">
        <span class="orb"></span>
        <div class="eyebrow" style="color: #c7d2fe;">المنهج الفلسطيني</div>
        @if(!$selectedMarketId)
            <h1>اختر <em>منطقة الدراسة</em></h1>
            <p>اختر منطقتك أولًا لتظهر لك المواد المناسبة لها.</p>
        @else
            <h1>اختر المادة التي <em>تناسبك</em></h1>
            <p>اطّلع على كل تفاصيل المادة قبل التسجيل: المدرس، مواعيد البث، عدد الحصص، الخطة التعليمية والنموذج المجاني.</p>
        @endif
    </div>
</section>

<main class="container catalog-main">
    @if(!$selectedMarketId)
        <form class="market-picker" method="get" action="{{ route('catalog') }}">
            <h2>اختر منطقة الدراسة</h2>
            <p>ستظهر لك المواد والمدرسون الخاصون بمنطقتك بعد الاختيار.</p>
            <div class="market-options">
                @foreach($markets as $marketId => $marketName)
                    <label class="market-option">
                        <input type="radio" name="market" value="{{ $marketId }}" required>
                        <span>{{ $marketName }}</span>
                    </label>
                @endforeach
            </div>
            <button class="button" type="submit">متابعة</button>
        </form>
    @else
        <nav class="tabs">
            <a href="{{ route('catalog', ['market' => $selectedMarketId]) }}" class="@if(!$selectedGradeId) active @endif">كل المواد</a>
            @foreach($allGrades as $grade)
                <a href="{{ route('catalog', ['market' => $selectedMarketId, 'grade' => $grade->id]) }}" 
                   class="@if($selectedGradeId === (int)$grade->id) active @endif">
                    {{ $grade->name }}
                </a>
            @endforeach
        </nav>

        <p class="catalog-note">المواد المتاحة في {{ $markets[$selectedMarketId] ?? 'منطقتك' }}. اضغط على أي مادة لمعرفة تفاصيل التسجيل والجدول والمدرس.</p>

        <section class="grid">
        @forelse($filteredSubjects as $subject)
            <article class="card">
                <div class="cover">
                    @if($subject->image_path)
                        <img src="{{ $subject->image_path }}" alt="{{ $subject->name }}">
                    @else
                        <div class="cover-placeholder">
                            @php
                                $subjectName = strtolower($subject->name);
                                $emoji = '📚'; // Default
                                
                                // Helper function to check multiple strings
                                $checkSubject = function($name, $keywords) {
                                    foreach ((array)$keywords as $keyword) {
                                        if (str_contains($name, $keyword)) {
                                            return true;
                                        }
                                    }
                                    return false;
                                };
                                
                                // Map subject names to emojis
                                if ($checkSubject($subjectName, ['رياضي', 'رياضة', 'إحصاء', 'جبر', 'هندسة', 'تفاضل'])) {
                                    $emoji = '📐';
                                } elseif ($checkSubject($subjectName, ['فيزياء', 'كيمياء', 'علوم', 'أحياء', 'علم', 'الطبيعة'])) {
                                    $emoji = '🧪';
                                } elseif ($checkSubject($subjectName, ['لغة عربية', 'عربي', 'نحو', 'بلاغة', 'أدب'])) {
                                    $emoji = '✍️';
                                } elseif ($checkSubject($subjectName, ['إنجليزي', 'لغة', 'english', 'ترجمة'])) {
                                    $emoji = '🌐';
                                } elseif ($checkSubject($subjectName, ['تاريخ', 'جغرافيا', 'اجتماعيات', 'دراسات'])) {
                                    $emoji = '🗺️';
                                } elseif ($checkSubject($subjectName, ['حاسوب', 'برمجة', 'تكنولوجيا', 'حسب', 'ict'])) {
                                    $emoji = '💻';
                                } elseif ($checkSubject($subjectName, ['قرآن', 'إسلام', 'ديني', 'شريعة', 'فقه'])) {
                                    $emoji = '📖';
                                } elseif ($checkSubject($subjectName, ['فن', 'تربية فنية', 'رسم'])) {
                                    $emoji = '🎨';
                                } elseif ($checkSubject($subjectName, ['رياضة', 'تربية بدنية'])) {
                                    $emoji = '⚽';
                                }
                            @endphp
                            {{ $emoji }}
                        </div>
                    @endif
                </div>
                <div class="card-copy">
                    <span class="tag">{{ $subject->grade->name ?? 'عام' }}</span>
                    <h2>{{ $subject->name }}</h2>
                    <p>{{ $subject->description ?: 'تفاصيل المساق وخطته متاحة في صفحة المادة.' }}</p>
                    <a class="button" href="{{ route('subjects.show', $subject->id) }}">عرض تفاصيل المادة</a>                </div>
            </article>
        @empty
            <p class="empty">لا توجد مواد منشورة حاليًا.</p>
        @endforelse
        </section>
    @endif
</main>

@endsection
