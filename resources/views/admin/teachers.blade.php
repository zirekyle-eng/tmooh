@extends('layouts.admin', ['title' => 'المدرسون'])

@section('content')
<style>
    .teachers-head { display:flex; justify-content:space-between; align-items:end; gap:18px; margin-bottom:24px; }
    .teachers-head h1 { margin:0; }
    .teachers-head p { margin:5px 0 0; }
    .add-teacher { border:0; border-radius:11px; padding:11px 16px; background:var(--c); color:#fff; font:800 12px Tajawal; cursor:pointer; }
    .add-teacher:hover { background:var(--cd); }
    .teachers-count { padding:9px 13px; border-radius:99px; background:#fff0eb; color:#d84e31; font-size:11px; font-weight:800; }
    .teachers-grid { display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:18px; }
    .teacher-card { position:relative; overflow:hidden; background:#fff; border:1px solid var(--line); border-radius:22px; padding:20px; }
    .teacher-card::before { content:''; position:absolute; inset:0 0 auto; height:5px; background:linear-gradient(90deg,var(--c),#ffc857); }
    .teacher-card-top { display:flex; align-items:center; gap:13px; margin-bottom:17px; }
    .teacher-avatar { width:66px; height:66px; flex:0 0 66px; display:grid; place-items:center; overflow:hidden; border-radius:20px; background:linear-gradient(135deg,#efe5ff,#fff0e9); color:var(--p); font-size:24px; font-weight:800; }
    .teacher-avatar img { width:100%; height:100%; object-fit:cover; }
    .teacher-card h2 { margin:0 0 4px; font-size:17px; }
    .teacher-specialization { margin:0; color:var(--muted); font-size:12px; }
    .teacher-status { display:inline-block; margin-top:7px; padding:4px 8px; border-radius:99px; font-size:10px; font-weight:800; }
    .teacher-status.active { background:#dcfce7; color:#166534; }
    .teacher-status.inactive { background:#fee2e2; color:#b91c1c; }
    .teacher-info { display:grid; gap:8px; margin:15px 0; padding:13px; background:#fffafc; border-radius:13px; color:var(--muted); font-size:11px; }
    .teacher-bio { min-height:42px; margin:0 0 16px; color:var(--muted); font-size:12px; line-height:1.8; }
    .edit-teacher { width:100%; border:0; border-radius:11px; padding:11px; background:var(--p); color:#fff; font:800 12px Tajawal; cursor:pointer; }
    .edit-teacher:hover { background:#51337b; }
    .modal-backdrop { position:fixed; inset:0; z-index:100; display:none; place-items:center; padding:18px; background:rgba(36,20,50,.48); }
    .modal-backdrop.open { display:grid; }
    .teacher-modal { width:min(560px,100%); max-height:calc(100vh - 36px); overflow:auto; background:#fff; border-radius:22px; padding:24px; box-shadow:0 24px 70px rgba(36,20,50,.25); }
    .modal-head { display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:18px; }
    .modal-head h2 { margin:0; }
    .close-modal { width:34px; height:34px; border:0; border-radius:10px; background:#fff0eb; color:#c7462d; font-size:20px; cursor:pointer; }
    .teacher-form { display:grid; grid-template-columns:1fr 1fr; gap:13px; }
    .teacher-form label { display:grid; gap:6px; font-size:12px; font-weight:800; }
    .teacher-form .wide { grid-column:1/-1; }
    .teacher-form textarea { min-height:100px; resize:vertical; }
    .modal-actions { display:flex; gap:8px; grid-column:1/-1; margin-top:4px; }
    .modal-actions .button { flex:1; }
    .cancel-modal { flex:1; border:1px solid var(--line); border-radius:99px; background:#fff; color:var(--muted); font:700 13px Tajawal; cursor:pointer; }
    @media(max-width:1050px){.teachers-grid{grid-template-columns:repeat(2,minmax(0,1fr))}}
    @media(max-width:620px){.teachers-head{display:block}.teachers-count{display:inline-block;margin-top:12px}.teachers-grid{grid-template-columns:1fr}.teacher-form{grid-template-columns:1fr}.teacher-form .wide{grid-column:auto}.modal-actions{grid-column:auto}}
</style>

<header class="teachers-head">
    <div>
        <h1>المدرسون</h1>
        <p class="muted">إدارة ملفات المدرسين ومعلومات التواصل والخبرة.</p>
    </div>
    <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap"><span class="teachers-count">{{ $teachers->count() }} مدرس</span><button class="add-teacher" type="button" id="add-teacher">+ إضافة مدرس جديد</button></div>
</header>

<div class="teachers-grid">
    @forelse($teachers as $teacher)
        <article class="teacher-card">
            <div class="teacher-card-top">
                <div class="teacher-avatar">
                    @if($teacher->photo_path)<img src="{{ asset(str_replace('public/', '', $teacher->photo_path)) }}" alt="{{ $teacher->full_name }}">@else{{ mb_substr($teacher->full_name, 0, 1) }}@endif
                </div>
                <div>
                    <h2>{{ $teacher->full_name }}</h2>
                    <p class="teacher-specialization">{{ $teacher->specialization ?: 'مدرس معتمد' }}</p>
                    <span class="teacher-status {{ $teacher->status === 'active' ? 'active' : 'inactive' }}">{{ $teacher->status === 'active' ? 'نشط' : 'غير نشط' }}</span>
                </div>
            </div>
            <div class="teacher-info">
                <span>☎ {{ $teacher->phone ?: 'لا يوجد هاتف' }}</span>
                <span>★ {{ $teacher->years_experience ?? 0 }} سنوات خبرة</span>
            </div>
            <p class="teacher-bio">{{ $teacher->bio ?: 'لم تتم إضافة نبذة تعريفية لهذا المدرس بعد.' }}</p>
            <button class="edit-teacher" type="button" data-teacher='@json($teacher)'>تعديل بيانات المدرس</button>
        </article>
    @empty
        <p class="muted">لا يوجد مدرسون.</p>
    @endforelse
</div>

<div class="modal-backdrop" id="teacher-modal" role="dialog" aria-modal="true" aria-labelledby="teacher-modal-title">
    <div class="teacher-modal">
        <div class="modal-head">
            <h2 id="teacher-modal-title">تعديل بيانات المدرس</h2>
            <button class="close-modal" type="button" aria-label="إغلاق">×</button>
        </div>
        <form class="teacher-form" id="teacher-form" method="post" enctype="multipart/form-data">
            @csrf
            <label>الاسم الكامل<input name="full_name" required></label>
            <label>رقم الهاتف<input name="phone" required></label>
            <label>التخصص<input name="specialization"></label>
            <label>سنوات الخبرة<input name="years_experience" type="number" min="0" max="60"></label>
            <label>الحالة<select name="status"><option value="active">نشط</option><option value="inactive">غير نشط</option></select></label>
            <label>الصورة<input name="photo" type="file" accept="image/jpeg,image/png,image/webp"></label>
            <label class="wide">كلمة السر الجديدة<input name="password" type="password" minlength="8" autocomplete="new-password"><small style="color:var(--muted);font-weight:500" id="password-note">اتركها فارغة للإبقاء على كلمة السر الحالية.</small></label>
            <label class="wide">نبذة تعريفية<textarea name="bio"></textarea></label>
            <div class="modal-actions">
                <button class="button" type="submit">حفظ التعديلات</button>
                <button class="cancel-modal" type="button">إلغاء</button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const modal = document.querySelector('#teacher-modal');
    const form = document.querySelector('#teacher-form');
    const modalTitle = document.querySelector('#teacher-modal-title');
    const password = form.elements.password;
    const passwordNote = document.querySelector('#password-note');
    const closeButtons = modal ? modal.querySelectorAll('.close-modal, .cancel-modal') : [];
    function closeModal() { modal.classList.remove('open'); }
    document.querySelectorAll('.edit-teacher').forEach(function (button) {
        button.addEventListener('click', function () {
            const teacher = JSON.parse(button.dataset.teacher);
            form.action = '{{ url('/admin/teachers') }}/' + teacher.id;
            modalTitle.textContent = 'تعديل بيانات المدرس';
            password.required = false;
            passwordNote.textContent = 'اتركها فارغة للإبقاء على كلمة السر الحالية.';
            form.elements.full_name.value = teacher.full_name || '';
            form.elements.phone.value = teacher.phone || '';
            form.elements.specialization.value = teacher.specialization || '';
            form.elements.years_experience.value = teacher.years_experience || 0;
            form.elements.status.value = teacher.status || 'active';
            form.elements.password.value = '';
            form.elements.bio.value = teacher.bio || '';
            modal.classList.add('open');
            form.elements.full_name.focus();
        });
    });
    document.querySelector('#add-teacher').addEventListener('click', function () {
        form.action = '{{ route('admin.teachers.store') }}';
        modalTitle.textContent = 'إضافة مدرس جديد';
        form.reset();
        form.elements.status.value = 'active';
        password.required = true;
        passwordNote.textContent = 'يجب أن تحتوي على 8 أحرف وحرف كبير ورمز خاص.';
        modal.classList.add('open');
        form.elements.full_name.focus();
    });
    closeButtons.forEach(function (button) { button.addEventListener('click', closeModal); });
    modal.addEventListener('click', function (event) { if (event.target === modal) closeModal(); });
    document.addEventListener('keydown', function (event) { if (event.key === 'Escape') closeModal(); });
});
</script>
@endsection
