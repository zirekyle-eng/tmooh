@extends('layouts.admin', ['title' => 'الجدول الدراسي'])

@section('content')
<style>
    .schedule-head { display:flex; justify-content:space-between; align-items:end; gap:18px; margin-bottom:22px; }
    .schedule-head h1 { margin:0; }
    .schedule-head p { margin:5px 0 0; }
    .schedule-layout { display:grid; gap:22px; }
    .schedule-form { display:grid; grid-template-columns:repeat(3, minmax(0, 1fr)); gap:14px; }
    .schedule-field { display:grid; gap:6px; }
    .schedule-field small { color:var(--muted); font-size:11px; font-weight:500; }
    .time-row { display:grid; grid-template-columns:1fr 1fr; gap:8px; }
    .schedule-form .button { grid-column:1/-1; }
    .schedule-calendar { display:grid; grid-template-columns:repeat(7,minmax(0,1fr)); gap:12px; align-items:start; }
    .calendar-toolbar { grid-column:1/-1; display:flex; align-items:center; justify-content:space-between; gap:10px; flex-wrap:wrap; }
    .calendar-toolbar h2 { margin:0; }
    .calendar-filter { display:flex; gap:7px; }
    .calendar-filter select { min-width:150px; }
    .day-column { min-height:310px; padding:10px; background:linear-gradient(180deg,#fffafc,#fff); border:1px solid var(--line); border-radius:16px; }
    .day-name { padding:9px 6px; border-radius:9px; background:#f0e9ff; color:#6041a5; text-align:center; font-weight:800; font-size:12px; }
    .day-empty { padding:40px 5px 15px; color:#9a8ca4; text-align:center; font-size:11px; }
    .class-card { margin-top:9px; padding:10px; background:#fff; border:1px solid var(--line); border-radius:11px; }
    .class-card[hidden], .day-empty[hidden] { display:none; }
    .class-time { display:inline-block; padding:5px 7px; border-radius:7px; background:#efe9ff; color:#6d4fd0; font-size:10px; font-weight:800; }
    .class-card h3 { margin:8px 0 3px; font-size:12px; }
    .class-card p { margin:0; color:var(--muted); font-size:10px; line-height:1.7; }
    .class-status { display:inline-block; margin-top:7px; padding:3px 6px; border-radius:99px; background:#dcfce7; color:#166534; font-size:9px; font-weight:800; }
    .class-status.off { background:#fee2e2; color:#b91c1c; }
    .class-tools { display:flex; gap:5px; margin-top:8px; }
    .class-tools button { flex:1; border:1px solid var(--line); border-radius:7px; padding:5px 3px; background:#fff; color:var(--muted); font:700 10px Tajawal; cursor:pointer; }
    .class-tools .delete { color:#b91c1c; }
    @media(max-width:1050px){.schedule-form{grid-template-columns:repeat(2,minmax(0,1fr))}.schedule-calendar{grid-template-columns:repeat(4,minmax(150px,1fr))}}
    @media(max-width:700px){.schedule-head{display:block}.schedule-form{grid-template-columns:1fr}.time-row{grid-template-columns:1fr}.calendar-toolbar{align-items:stretch}.calendar-filter{width:100%;flex-direction:column}.calendar-filter select{width:100%}.schedule-calendar{grid-template-columns:repeat(2,minmax(145px,1fr))}}
    @media(max-width:420px){.schedule-calendar{grid-template-columns:1fr}}
</style>

<header class="schedule-head">
    <div>
        <h1>الجدول الدراسي</h1>
        <p class="muted">أضف الحصص ورتبها حسب اليوم والوقت والمدرس.</p>
    </div>
</header>

<div class="schedule-layout">
    <section class="panel schedule-form-panel">
        <h2>إضافة حصة للجدول</h2>
        <form class="schedule-form" method="post" action="{{ route('admin.schedule.store') }}">
            @csrf
            <label class="schedule-field">الصف الدراسي
                <select id="schedule-grade" required>
                    <option value="">اختر الصف أولًا</option>
                    @foreach($grades as $grade)<option value="{{ $grade->id }}">{{ $grade->name }}</option>@endforeach
                </select>
            </label>
            <label class="schedule-field">المادة
                <select name="subject_id" id="schedule-subject" required>
                    <option value="">اختر المادة</option>
                    @foreach($subjects as $subject)<option value="{{ $subject->id }}" data-grade="{{ $subject->grade_id }}">{{ $subject->name }}</option>@endforeach
                </select>
            </label>
            <label class="schedule-field">المدرس
                <select name="teacher_id" required>
                    <option value="">اختر المدرس</option>
                    @foreach($teachers as $teacher)<option value="{{ $teacher->id }}">{{ $teacher->full_name }}</option>@endforeach
                </select>
            </label>
            <label class="schedule-field">اليوم
                <select name="day_of_week" required>@foreach($days as $dayNumber => $dayName)<option value="{{ $dayNumber }}">{{ $dayName }}</option>@endforeach</select>
            </label>
            <div class="time-row">
                <label class="schedule-field">من<input type="time" name="starts_at" required></label>
                <label class="schedule-field">إلى<input type="time" name="ends_at" required></label>
            </div>
            <label class="schedule-field">رمز الغرفة <small>اختياري</small><input name="room_code" placeholder="مثال: A-101"></label>
            <label class="schedule-field">معرّف الغرفة الافتراضية <small>اختياري</small><input name="viva_z_meeting_id" placeholder="Meeting ID"></label>
            <label class="schedule-field">رابط دخول الغرفة <small>اختياري</small><input name="viva_z_join_url" type="url" placeholder="https://..."></label>
            <button class="button" type="submit">إضافة إلى الجدول</button>
        </form>
    </section>

    <section class="panel schedule-calendar-panel">
        <div class="schedule-calendar">
            <div class="calendar-toolbar">
                <h2>الحصص الأسبوعية</h2>
                <div class="calendar-filter">
                    <select id="calendar-grade"><option value="">كل الصفوف</option>@foreach($grades as $grade)<option value="{{ $grade->id }}">{{ $grade->name }}</option>@endforeach</select>
                    <select id="calendar-subject"><option value="">كل المواد</option>@foreach($subjects as $subject)<option value="{{ $subject->id }}" data-grade="{{ $subject->grade_id }}">{{ $subject->name }}</option>@endforeach</select>
                </div>
            </div>
            @foreach($days as $dayNumber => $dayName)
                @php($dayClasses = $classes->where('day_of_week', $dayNumber))
                <div class="day-column" data-day="{{ $dayNumber }}">
                    <div class="day-name">{{ $dayName }}</div>
                    @forelse($dayClasses as $class)
                        <article class="class-card" data-grade="{{ $class->grade_id }}" data-subject="{{ $class->subject_id }}">
                            <span class="class-time">{{ substr($class->starts_at, 0, 5) }} - {{ substr($class->ends_at, 0, 5) }}</span>
                            <h3>{{ $class->subject_name }}</h3>
                            <p>{{ $class->teacher_name }}</p>
                            <p>{{ $class->room_code ?: 'بدون رمز غرفة' }}</p>
                            <span class="class-status {{ $class->status !== 'active' ? 'off' : '' }}">{{ $class->status === 'active' ? 'مفعلة' : 'موقوفة' }}</span>
                            <div class="class-tools">
                                <form method="post" action="{{ route('admin.schedule.toggle', $class->id) }}">@csrf<button type="submit">{{ $class->status === 'active' ? 'إيقاف' : 'تفعيل' }}</button></form>
                                <form method="post" action="{{ route('admin.schedule.delete', $class->id) }}" onsubmit="return confirm('حذف الحصة؟')">@csrf @method('DELETE')<button class="delete" type="submit">حذف</button></form>
                            </div>
                        </article>
                    @empty
                        <p class="day-empty">لا توجد حصص</p>
                    @endforelse
                </div>
            @endforeach
        </div>
    </section>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const grade = document.querySelector('#schedule-grade');
    const subject = document.querySelector('#schedule-subject');
    const calendarGrade = document.querySelector('#calendar-grade');
    const calendarSubject = document.querySelector('#calendar-subject');
    function filterSubjects(select, gradeValue) {
        if (!select) return;
        Array.from(select.options).forEach(function (option) {
            if (!option.value) return;
            option.hidden = Boolean(gradeValue && option.dataset.grade !== gradeValue);
        });
        if (select.value && select.selectedOptions[0].hidden) select.value = '';
    }
    function refreshCalendar() {
        if (!calendarGrade || !calendarSubject) return;
        const gradeValue = calendarGrade.value;
        filterSubjects(calendarSubject, gradeValue);
        const subjectValue = calendarSubject.value;
        document.querySelectorAll('.day-column').forEach(function (day) {
            let visibleCards = 0;
            day.querySelectorAll('.class-card').forEach(function (card) {
                const matchesGrade = !gradeValue || card.dataset.grade === gradeValue;
                const matchesSubject = !subjectValue || card.dataset.subject === subjectValue;
                card.hidden = !(matchesGrade && matchesSubject);
                if (matchesGrade && matchesSubject) visibleCards += 1;
            });
            const emptyMessage = day.querySelector('.day-empty');
            if (emptyMessage) emptyMessage.hidden = visibleCards > 0;
        });
    }
    if (grade && subject) {
        grade.addEventListener('change', function () { filterSubjects(subject, grade.value); });
    }
    if (calendarGrade && calendarSubject) {
        calendarGrade.addEventListener('change', refreshCalendar);
        calendarSubject.addEventListener('change', refreshCalendar);
        refreshCalendar();
    }
});
</script>
@endsection
