@extends('layouts.admin', ['title' => 'تسجيل الطلاب'])

@section('content')
<style>
    .enroll-head{display:flex;justify-content:space-between;align-items:end;gap:18px;margin-bottom:24px}.enroll-head h1{margin:0}.enroll-head p{margin:5px 0 0}.student-count{padding:9px 13px;border-radius:99px;background:#fff0eb;color:#d84e31;font-size:11px;font-weight:800}.enroll-layout{display:grid;grid-template-columns:minmax(0,1.35fr) minmax(280px,.65fr);gap:22px;align-items:start}.enroll-form{display:grid;gap:16px}.field{display:grid;gap:7px;font-size:12px;font-weight:800}.field small{color:var(--muted);font-weight:500}.subjects-heading{display:flex;justify-content:space-between;align-items:center;gap:10px}.subjects-heading h2{margin:0}.subject-count{color:var(--muted);font-size:11px}.subjects-grid{display:grid;grid-template-columns:repeat(2,minmax(0,1fr));gap:10px}.subject-option{display:flex;align-items:flex-start;gap:9px;padding:12px;border:1px solid var(--line);border-radius:12px;background:#fff;cursor:pointer;font-size:12px;font-weight:700}.subject-option:has(input:checked){border-color:var(--c);background:#fff6f2;box-shadow:0 4px 12px rgba(255,107,74,.1)}.subject-option input{margin-top:3px;accent-color:var(--c)}.subject-option span{display:grid;gap:3px}.subject-option small{color:var(--muted);font-size:10px;font-weight:500}.payment-fields{display:grid;grid-template-columns:1fr 1fr;gap:12px}.save-enrollment{border:0;border-radius:12px;background:var(--c);color:#fff;padding:13px;font:800 13px Tajawal;cursor:pointer}.students-list{display:grid;gap:10px;max-height:650px;overflow:auto}.student-card{padding:14px;border:1px solid var(--line);border-radius:14px;background:#fff}.student-card strong{display:block;font-size:13px}.student-card span{display:block;margin-top:4px;color:var(--muted);font-size:11px}.student-status{display:inline-block!important;width:max-content;margin-top:8px!important;padding:3px 7px;border-radius:99px;background:#dcfce7;color:#166534!important;font-size:9px!important;font-weight:800}.student-status.off{background:#fee2e2;color:#b91c1c!important}.empty-state{color:var(--muted);font-size:12px}@media(max-width:1000px){.enroll-layout{grid-template-columns:1fr}}@media(max-width:620px){.enroll-head{display:block}.student-count{display:inline-block;margin-top:12px}.subjects-grid,.payment-fields{grid-template-columns:1fr}}
</style>

<header class="enroll-head"><div><h1>تسجيل طالب في مادة أو باقة</h1><p class="muted">اختر الطالب والمواد، ثم ارفع إشعار الدفع لاعتماد التسجيل مباشرة.</p></div><span class="student-count">{{ $students->count() }} طالب مسجل</span></header>

<div class="enroll-layout">
    <section class="panel">
        <form class="enroll-form" method="post" action="{{ route('admin.students.enroll') }}" enctype="multipart/form-data">
            @csrf
            <label class="field">الطالب
                <select name="student_id" required><option value="">اختر الطالب</option>@foreach($enrollmentStudents as $student)<option value="{{ $student->id }}">{{ $student->full_name }}{{ $student->phone ? ' - '.$student->phone : '' }}</option>@endforeach</select>
            </label>
            <div class="field"><div class="subjects-heading"><h2>المواد</h2><span class="subject-count" id="selected-count">0 مواد محددة</span></div><div class="subjects-grid">@forelse($subjects as $subject)<label class="subject-option"><input type="checkbox" name="subject_ids[]" value="{{ $subject->id }}"><span>{{ $subject->name }}<small>{{ $subject->grade_name }}</small></span></label>@empty<p class="empty-state">لا توجد مواد منشورة.</p>@endforelse</div></div>
            <div class="payment-fields"><label class="field">المبلغ المدفوع الإجمالي<input type="number" name="amount" min="0.01" step="0.01" required placeholder="0.00"></label><label class="field">مرجع الدفع <small>اختياري</small><input name="reference" maxlength="120" placeholder="رقم العملية أو المرجع"></label></div>
            <label class="field">إشعار الدفع <small>إلزامي: JPG أو PNG أو WebP أو PDF، بحد أقصى 8MB</small><input type="file" name="receipt" accept="image/jpeg,image/png,image/webp,application/pdf" required></label>
            <button class="save-enrollment" type="submit">تسجيل الطالب واعتماد الدفع</button>
        </form>
    </section>

    <aside class="panel"><h2>الطلاب والتسجيلات</h2><div class="students-list">@forelse($students as $student)<article class="student-card"><strong>{{ $student->full_name }}</strong><span>{{ $student->phone ?: 'بدون هاتف' }}</span><span>{{ $student->country ?: '—' }} / {{ $student->city ?: '—' }}</span><span>{{ $student->subjects }} مواد مسجلة</span><span class="student-status {{ $student->status !== 'active' ? 'off' : '' }}">{{ $student->status === 'active' ? 'نشط' : 'غير نشط' }}</span></article>@empty<p class="empty-state">لا يوجد طلاب.</p>@endforelse</div></aside>
</div>

<script>
document.addEventListener('DOMContentLoaded',function(){const count=document.querySelector('#selected-count');const boxes=document.querySelectorAll('input[name="subject_ids[]"]');function update(){const selected=document.querySelectorAll('input[name="subject_ids[]"]:checked').length;count.textContent=selected+' مواد محددة'}boxes.forEach(function(box){box.addEventListener('change',update)})});
</script>
@endsection
