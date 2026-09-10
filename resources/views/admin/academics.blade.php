@extends('layouts.admin', ['title' => 'الصفوف والمواد'])

@section('content')
<style>
    .academics-head { display:flex; justify-content:space-between; align-items:end; gap:18px; margin-bottom:22px; }
    .academics-head h1 { margin:0; }
    .academics-head p { margin:5px 0 0; }
    .academic-layout { display:grid; grid-template-columns:minmax(0, 1.35fr) minmax(310px, .65fr); gap:22px; align-items:start; }
    .form-grid { display:grid; grid-template-columns:1fr 1fr; gap:14px; }
    .form-grid .wide { grid-column:1/-1; }
    .field { display:grid; gap:6px; }
    .field small { color:var(--muted); font-weight:500; }
    .form-section { grid-column:1/-1; margin-top:5px; padding-top:14px; border-top:1px solid var(--line); color:var(--muted); font-size:12px; font-weight:800; }
    .subjects-list { display:grid; gap:10px; max-height:760px; overflow:auto; }
    .subject-card { display:grid; grid-template-columns:64px 1fr; gap:12px; padding:12px; border:1px solid var(--line); border-radius:14px; background:#fff; }
    .subject-image { width:64px; height:64px; border-radius:12px; object-fit:cover; background:linear-gradient(135deg,#ff6b4a,#51337b); }
    .subject-card h3 { margin:0 0 4px; font-size:15px; }
    .subject-card p { margin:0; color:var(--muted); font-size:11px; line-height:1.8; }
    .subject-tags { display:flex; flex-wrap:wrap; gap:5px; margin-top:7px; }
    .subject-tags span { padding:3px 7px; border-radius:99px; background:#f7effa; color:var(--muted); font-size:10px; font-weight:700; }
    @media(max-width:960px){.academic-layout{grid-template-columns:1fr}}
    @media(max-width:600px){.academics-head{display:block}.form-grid{grid-template-columns:1fr}.panel{padding:16px}}
</style>

<header class="academics-head">
    <div>
        <h1>الصفوف والمواد الدراسية</h1>
        <p class="muted">أضف المادة مع بياناتها التعليمية والتفاصيل التي ستظهر للطلاب.</p>
    </div>
</header>

<div class="academic-layout">
    <section class="panel">
        <h2>إضافة مادة جديدة</h2>
        <form method="post" action="{{ route('admin.subjects.store') }}" enctype="multipart/form-data" class="form-grid">
            @csrf
            <label class="field">الصف الدراسي
                <select name="grade_id" required>
                    <option value="">اختر الصف</option>
                    @foreach($grades as $grade)<option value="{{ $grade->id }}">{{ $grade->name }}</option>@endforeach
                </select>
            </label>
            <label class="field">منطقة الدراسة
                <select name="market_id" required>
                    <option value="1">قطاع غزة</option><option value="2">الضفة الغربية</option><option value="3">مصر</option>
                </select>
            </label>
            <label class="field">الفرع
                <select name="tawjihi_branch" required>
                    <option value="general">مواد مشتركة</option><option value="scientific">العلمي</option><option value="literary">الأدبي</option><option value="sharia">الشرعي</option><option value="entrepreneurship">الريادة والأعمال</option><option value="vocational">المهني والصناعي</option>
                </select>
            </label>
            <label class="field">المدرس الأساسي
                <select name="primary_teacher_id"><option value="">اختر المدرس</option>@foreach($teachers as $teacher)<option value="{{ $teacher->id }}">{{ $teacher->full_name }}</option>@endforeach</select>
            </label>
            <label class="field wide">اسم المادة
                <input name="name" required placeholder="مثال: الرياضيات - التوجيهي">
            </label>
            <label class="field">مدة الاشتراك
                <select name="enrollment_term" required><option value="full_year">المنهج كاملًا</option><option value="first">الفصل الأول</option><option value="second">الفصل الثاني</option></select>
            </label>
            <label class="field">صورة المادة
                <input name="image" type="file" accept="image/jpeg,image/png,image/webp"><small>JPG أو PNG أو WebP، بحد أقصى 4MB</small>
            </label>
            <label class="field">عدد الحصص أسبوعيًا
                <input name="sessions_per_week" type="number" min="1" value="2" required>
            </label>
            <label class="field">إجمالي الساعات
                <input name="total_hours" type="number" min="0" step=".5" placeholder="اختياري">
            </label>
            <label class="field">تاريخ البداية<input name="start_date" type="date"></label>
            <label class="field">تاريخ النهاية<input name="end_date" type="date"></label>

            <div class="form-section">تفاصيل تعليمية إضافية</div>
            <label class="field wide">وصف المادة
                <textarea name="description" rows="3" placeholder="وصف مختصر يظهر للطلاب"></textarea>
            </label>
            <label class="field wide">خطة الوحدات
                <textarea name="unit_plan" rows="4" placeholder="الوحدات والمواضيع الرئيسية"></textarea>
            </label>
            <label class="field wide">سياسة تعويض الحصص
                <textarea name="make_up_policy" rows="3" placeholder="ماذا يحدث عند تأجيل أو إلغاء حصة؟"></textarea>
            </label>
            <label class="field">نوع المحاضرات
                <select name="delivery_type" id="delivery-type"><option value="live">مباشرة حسب الجدول</option><option value="recorded">محاضرات مسجلة</option></select>
            </label>
            <label class="field wide" id="recorded-url-field" hidden>رابط المحاضرات المسجلة
                <input name="recorded_lectures_url" id="recorded-url" type="url" placeholder="https://...">
                <small>يظهر للطالب بدل جدول الحصص.</small>
            </label>
            <label class="field wide">رابط نموذج أو حصة مجانية
                <input name="free_preview_url" type="url" placeholder="https://...">
            </label>
            <button class="button wide" type="submit">إضافة المادة</button>
        </form>
    </section>

    <aside class="panel">
        <h2>المواد المسجلة</h2>
        <div class="subjects-list">
            @forelse($subjects as $subject)
                <article class="subject-card">
                    @if($subject->image_path)<img class="subject-image" src="{{ asset($subject->image_path) }}" alt="{{ $subject->name }}">@else<div class="subject-image"></div>@endif
                    <div>
                        <h3>{{ $subject->name }}</h3>
                        <p>{{ $subject->description ?: 'لا يوجد وصف مختصر لهذه المادة.' }}</p>
                        <div class="subject-tags">
                            <span>{{ $subject->grade_name }}</span>
                            <span>{{ ['general'=>'مشتركة','scientific'=>'العلمي','literary'=>'الأدبي','sharia'=>'الشرعي','entrepreneurship'=>'الريادة','vocational'=>'المهني'][$subject->tawjihi_branch] ?? 'مشتركة' }}</span>
                            <span>{{ $subject->delivery_type === 'recorded' ? 'مسجلة' : 'مباشرة' }}</span>
                            <span>{{ $subject->sessions_per_week ?? 2 }} حصص أسبوعيًا</span>
                        </div>
                    </div>
                </article>
            @empty
                <p class="muted">لا توجد مواد بعد.</p>
            @endforelse
        </div>
    </aside>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const type = document.querySelector('#delivery-type');
    const field = document.querySelector('#recorded-url-field');
    const url = document.querySelector('#recorded-url');
    if (!type || !field || !url) return;
    function refresh() { const recorded = type.value === 'recorded'; field.hidden = !recorded; url.required = recorded; }
    type.addEventListener('change', refresh);
    refresh();
});
</script>
@endsection
