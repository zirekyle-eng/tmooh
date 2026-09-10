<?php

namespace App\Http\Controllers;

use App\Services\BigBlueButtonService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function dashboard(): View
    {
        $stats = [
            'students' => DB::table('users')->where('role', 'student')->count(),
            'teachers' => DB::table('users')->where('role', 'teacher')->count(),
            'subjects' => DB::table('subjects')->where('status', 'active')->count(),
            'payments' => DB::table('payments')->where('status', 'pending')->count(),
        ];
        $payments = DB::table('payments as p')
            ->join('users as u', 'u.id', '=', 'p.student_id')
            ->leftJoin('enrollments as e', 'e.id', '=', 'p.enrollment_id')
            ->leftJoin('subjects as s', 's.id', '=', 'e.subject_id')
            ->where('p.status', 'pending')
            ->orderByDesc('p.created_at')
            ->limit(5)
            ->select('p.amount', 'p.method', 'u.full_name as student', 's.name as subject')
            ->get();
        $unreadNotifications = DB::table('admin_notifications')->where('is_read', 0)->count();

        return view('admin.dashboard', compact('stats', 'payments', 'unreadNotifications'));
    }

    public function teacherDashboard(): View
    {
        return view('teacher.dashboard');
    }

    public function students(): View
    {
        $students = DB::table('users as u')
            ->leftJoin('enrollments as e', 'e.student_id', '=', 'u.id')
            ->where('u.role', 'student')
            ->groupBy('u.id', 'u.full_name', 'u.phone', 'u.country', 'u.city', 'u.status', 'u.created_at')
            ->orderByDesc('u.created_at')
            ->select('u.id', 'u.full_name', 'u.phone', 'u.country', 'u.city', 'u.status', DB::raw('COUNT(e.id) as subjects'))
            ->get();

        $enrollmentStudents = DB::table('users')->where('role', 'student')->orderBy('full_name')->get(['id', 'full_name', 'phone']);
        $subjects = DB::table('subjects as s')
            ->join('grades as g', 'g.id', '=', 's.grade_id')
            ->where('s.status', 'active')
            ->orderBy('g.sort_order')->orderBy('s.name')
            ->get(['s.id', 's.name', 's.monthly_fee', 's.grade_id', 'g.name as grade_name']);

        return view('admin.students', compact('students', 'enrollmentStudents', 'subjects'));
    }

    public function enrollStudent(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'student_id' => ['required', 'integer', 'exists:users,id'],
            'subject_ids' => ['required', 'array', 'min:1'],
            'subject_ids.*' => ['integer', 'distinct', 'exists:subjects,id'],
            'amount' => ['required', 'numeric', 'gt:0'],
            'reference' => ['nullable', 'string', 'max:120'],
            'receipt' => ['required', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:8192'],
        ], [
            'subject_ids.required' => 'اختر مادة واحدة على الأقل.',
            'amount.gt' => 'أدخل مبلغًا أكبر من صفر.',
            'receipt.required' => 'إشعار الدفع مطلوب.',
            'receipt.mimes' => 'ارفع JPG أو PNG أو WebP أو PDF.',
            'receipt.max' => 'حجم الإيصال يجب ألا يتجاوز 8MB.',
        ]);

        abort_unless(DB::table('users')->where('id', $data['student_id'])->where('role', 'student')->exists(), 422, 'الطالب غير موجود.');

        $directory = public_path('uploads/payments');
        if (!is_dir($directory)) mkdir($directory, 0755, true);
        $extension = $request->file('receipt')->extension();
        $filename = 'admin_receipt_' . bin2hex(random_bytes(10)) . '.' . $extension;
        abort_unless($request->file('receipt')->move($directory, $filename), 422, 'تعذر حفظ إشعار الدفع.');
        $receiptPath = 'public/uploads/payments/' . $filename;

        $newSubjectIds = array_values(array_filter($data['subject_ids'], function (int $subjectId) use ($data): bool {
            return !DB::table('enrollments')
                ->where('student_id', $data['student_id'])
                ->where('subject_id', $subjectId)
                ->exists();
        }));

        if (!$newSubjectIds) {
            @unlink($directory . '/' . $filename);

            return back()->withErrors(['subject_ids' => 'الطالب مسجل مسبقًا في جميع المواد المحددة.']);
        }

        $amountPerSubject = (float) $data['amount'] / count($newSubjectIds);

        DB::transaction(function () use ($data, $request, $receiptPath, $amountPerSubject, $newSubjectIds): void {
            foreach ($newSubjectIds as $subjectId) {
                $enrollmentId = DB::table('enrollments')->insertGetId([
                    'student_id' => $data['student_id'], 'subject_id' => $subjectId,
                    'starts_on' => now()->toDateString(), 'status' => 'active',
                ]);
                DB::table('payments')->insert([
                    'student_id' => $data['student_id'], 'enrollment_id' => $enrollmentId,
                    'amount' => $amountPerSubject, 'method' => 'bank_transfer',
                    'reference' => $data['reference'] ?? null, 'receipt_path' => $receiptPath,
                    'status' => 'approved', 'paid_at' => now(), 'reviewed_by' => $request->user()->id,
                    'created_at' => now(),
                ]);
            }
        });

        return back()->with('success', 'تم تسجيل الطالب في المواد المحددة واعتماد الدفع.');
    }

    public function teachers(): View
    {
        $teachers = DB::table('users as u')
            ->leftJoin('teachers_profiles as tp', 'tp.user_id', '=', 'u.id')
            ->where('u.role', 'teacher')
            ->orderByDesc('u.created_at')
            ->select('u.id', 'u.full_name', 'u.phone', 'u.status', 'tp.specialization', 'tp.years_experience', 'tp.bio', 'tp.photo_path')
            ->get();

        return view('admin.teachers', compact('teachers'));
    }

    public function storeTeacher(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:160'],
            'phone' => ['required', 'string', 'max:30', 'unique:users,phone'],
            'specialization' => ['nullable', 'string', 'max:180'],
            'years_experience' => ['nullable', 'integer', 'min:0', 'max:60'],
            'bio' => ['nullable', 'string'],
            'password' => ['required', 'string', 'min:8', 'regex:/[A-Z]/', 'regex:/[^a-zA-Z0-9]/'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $directory = public_path('uploads/teachers');
            if (!is_dir($directory)) mkdir($directory, 0755, true);
            $filename = 'teacher_' . bin2hex(random_bytes(8)) . '.' . $request->file('photo')->extension();
            $request->file('photo')->move($directory, $filename);
            $photoPath = 'public/uploads/teachers/' . $filename;
        }

        DB::transaction(function () use ($data, $photoPath): void {
            $teacherId = DB::table('users')->insertGetId([
                'full_name' => $data['full_name'], 'phone' => $data['phone'],
                'password_hash' => Hash::make($data['password']), 'role' => 'teacher', 'status' => 'active',
                'created_at' => now(), 'updated_at' => now(),
            ]);
            DB::table('teachers_profiles')->insert([
                'user_id' => $teacherId, 'specialization' => $data['specialization'] ?? null,
                'years_experience' => $data['years_experience'] ?? 0, 'bio' => $data['bio'] ?? null,
                'photo_path' => $photoPath,
            ]);
        });

        return back()->with('success', 'تمت إضافة المدرس بنجاح.');
    }

    public function updateTeacher(Request $request, int $id): RedirectResponse
    {
        $teacher = DB::table('users')->where('id', $id)->where('role', 'teacher')->first();
        abort_unless($teacher, 404);

        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:160'],
            'phone' => ['required', 'string', 'max:30', 'unique:users,phone,' . $id],
            'specialization' => ['nullable', 'string', 'max:180'],
            'years_experience' => ['nullable', 'integer', 'min:0', 'max:60'],
            'bio' => ['nullable', 'string'],
            'status' => ['required', 'in:active,inactive'],
            'password' => ['nullable', 'string', 'min:8', 'regex:/[A-Z]/', 'regex:/[^a-zA-Z0-9]/'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $directory = public_path('uploads/teachers');
            if (!is_dir($directory)) mkdir($directory, 0755, true);
            $filename = 'teacher_' . $id . '_' . bin2hex(random_bytes(6)) . '.' . $request->file('photo')->extension();
            $request->file('photo')->move($directory, $filename);
            $photoPath = 'public/uploads/teachers/' . $filename;
        }

        DB::transaction(function () use ($id, $data, $photoPath): void {
            $userData = [
                'full_name' => $data['full_name'],
                'phone' => $data['phone'],
                'status' => $data['status'],
            ];
            if (!empty($data['password'])) $userData['password_hash'] = Hash::make($data['password']);
            DB::table('users')->where('id', $id)->update($userData);
            $profile = [
                'specialization' => $data['specialization'] ?? null,
                'years_experience' => $data['years_experience'] ?? 0,
                'bio' => $data['bio'] ?? null,
            ];
            if ($photoPath !== null) $profile['photo_path'] = $photoPath;
            DB::table('teachers_profiles')->updateOrInsert(['user_id' => $id], $profile);
        });

        return back()->with('success', 'تم حفظ تعديلات المدرس.');
    }

    public function schedule(): View
    {
        $classes = DB::table('class_schedules as cs')
            ->join('subjects as s', 's.id', '=', 'cs.subject_id')
            ->join('grades as g', 'g.id', '=', 's.grade_id')
            ->join('users as u', 'u.id', '=', 'cs.teacher_id')
            ->leftJoin('teachers_profiles as tp', 'tp.user_id', '=', 'u.id')
            ->orderBy('cs.day_of_week')->orderBy('cs.starts_at')
            ->select('cs.*', 's.name as subject_name', 's.grade_id', 'g.name as grade_name', 'u.full_name as teacher_name', 'tp.photo_path')
            ->get();
        $subjects = DB::table('subjects')->where('status', 'active')->orderBy('name')->get();
        $grades = DB::table('grades')->orderBy('sort_order')->orderBy('name')->get();
        $teachers = DB::table('users')->where('role', 'teacher')->where('status', 'active')->orderBy('full_name')->get(['id', 'full_name']);
        $days = [1 => 'السبت', 2 => 'الأحد', 3 => 'الإثنين', 4 => 'الثلاثاء', 5 => 'الأربعاء', 6 => 'الخميس', 7 => 'الجمعة'];

        return view('admin.schedule', compact('classes', 'subjects', 'grades', 'teachers', 'days'));
    }

    public function storeSchedule(Request $request, BigBlueButtonService $bigBlueButton): RedirectResponse
    {
        $data = $request->validate([
            'subject_id' => ['required', 'integer', 'exists:subjects,id'],
            'teacher_id' => ['required', 'integer', 'exists:users,id'],
            'day_of_week' => ['required', 'integer', 'between:1,7'],
            'starts_at' => ['required', 'date_format:H:i'],
            'ends_at' => ['required', 'date_format:H:i', 'after:starts_at'],
            'room_code' => ['nullable', 'string', 'max:100'],
            'viva_z_meeting_id' => ['nullable', 'string', 'max:150'],
            'viva_z_join_url' => ['nullable', 'url', 'max:500'],
        ]);

        if (!$data['viva_z_join_url'] && config('services.bbb.base_url') && config('services.bbb.secret')) {
            try {
                $meetingId = 'class-' . bin2hex(random_bytes(8));
                $data['viva_z_meeting_id'] = $meetingId;
                $data['viva_z_join_url'] = $bigBlueButton->createMeeting('حصة رقم ' . $data['subject_id'], $meetingId);
            } catch (\Throwable $exception) {
                return back()->withErrors(['viva_z_join_url' => $exception->getMessage()])->withInput();
            }
        }

        $data['status'] = 'active';
        DB::table('class_schedules')->insert($data);

        return back()->with('success', 'تمت إضافة الحصة إلى الجدول.');
    }

    public function toggleSchedule(int $id): RedirectResponse
    {
        DB::table('class_schedules')->where('id', $id)->update([
            'status' => DB::raw("IF(status = 'active', 'cancelled', 'active')"),
        ]);

        return back()->with('success', 'تم تحديث حالة الحصة.');
    }

    public function deleteSchedule(int $id): RedirectResponse
    {
        DB::table('class_schedules')->where('id', $id)->delete();

        return back()->with('success', 'تم حذف الحصة.');
    }

    public function accounts(): View
    {
        $accounts = DB::table('users')->orderByDesc('created_at')->select('id', 'full_name', 'email', 'phone', 'role', 'status', 'country', 'city', 'market_id', 'created_at')->get();

        return view('admin.accounts', compact('accounts'));
    }

    public function updateAccount(Request $request, int $id): RedirectResponse
    {
        $account = DB::table('users')->where('id', $id)->first();
        abort_unless($account, 404);

        $data = $request->validate([
            'full_name' => ['required', 'string', 'max:160'],
            'email' => ['nullable', 'email', 'max:160', 'unique:users,email,' . $id],
            'phone' => ['required', 'string', 'max:30', 'unique:users,phone,' . $id],
            'role' => ['required', 'in:student,teacher,admin'],
            'status' => ['required', 'in:active,inactive'],
            'country' => ['nullable', 'string', 'max:80'],
            'city' => ['nullable', 'string', 'max:100'],
            'password' => ['nullable', 'string', 'min:8', 'regex:/[A-Z]/', 'regex:/[^a-zA-Z0-9]/'],
        ]);

        $userData = [
            'full_name' => $data['full_name'], 'email' => $data['email'] ?? null,
            'phone' => $data['phone'], 'role' => $data['role'], 'status' => $data['status'],
            'country' => $data['country'] ?? null, 'city' => $data['city'] ?? null,
        ];
        if (!empty($data['password'])) $userData['password_hash'] = Hash::make($data['password']);
        DB::table('users')->where('id', $id)->update($userData);

        return back()->with('success', 'تم حفظ تعديلات الحساب.');
    }
}