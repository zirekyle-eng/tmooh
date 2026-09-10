<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class TeacherController extends Controller
{
    public function dashboard(Request $request): View
    {
        $teacher = $request->user();
        $profile = DB::table('users as u')->leftJoin('teachers_profiles as tp', 'tp.user_id', '=', 'u.id')->where('u.id', $teacher->id)->select('u.full_name', 'u.phone', 'tp.specialization', 'tp.years_experience', 'tp.bio', 'tp.photo_path')->first();
        $classes = DB::table('class_schedules as cs')->join('subjects as s', 's.id', '=', 'cs.subject_id')->join('grades as g', 'g.id', '=', 's.grade_id')->where('cs.teacher_id', $teacher->id)->where('cs.status', 'active')->orderBy('cs.day_of_week')->orderBy('cs.starts_at')->select('cs.*', 's.name as subject_name', 'g.name as grade_name', DB::raw('(SELECT COUNT(*) FROM student_schedule ss WHERE ss.schedule_id = cs.id AND (ss.active_until IS NULL OR ss.active_until >= CURDATE())) as students'))->get();
        $subjects = DB::table('class_schedules as cs')->join('subjects as s', 's.id', '=', 'cs.subject_id')->join('grades as g', 'g.id', '=', 's.grade_id')->where('cs.teacher_id', $teacher->id)->where('cs.status', 'active')->distinct()->orderBy('s.name')->select('s.name as subject_name', 'g.name as grade_name')->get();

        return view('teacher.dashboard', compact('profile', 'classes', 'subjects'));
    }

    public function updateProfile(Request $request): RedirectResponse
    {
        $teacher = $request->user();
        $data = $request->validate(['full_name' => ['required', 'string', 'max:160'], 'phone' => ['required', 'string', 'max:30', 'unique:users,phone,' . $teacher->id], 'specialization' => ['nullable', 'string', 'max:180'], 'years_experience' => ['nullable', 'integer', 'min:0', 'max:60'], 'bio' => ['nullable', 'string'], 'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072']]);
        $photoPath = null;
        if ($request->hasFile('photo')) {
            $directory = public_path('uploads/teachers');
            if (!is_dir($directory)) mkdir($directory, 0755, true);
            $filename = 'teacher_' . $teacher->id . '_' . bin2hex(random_bytes(6)) . '.' . $request->file('photo')->extension();
            $request->file('photo')->move($directory, $filename);
            $photoPath = 'public/uploads/teachers/' . $filename;
        }
        DB::transaction(function () use ($teacher, $data, $photoPath): void {
            DB::table('users')->where('id', $teacher->id)->update(['full_name' => $data['full_name'], 'phone' => $data['phone']]);
            $profile = ['specialization' => $data['specialization'] ?? null, 'years_experience' => $data['years_experience'] ?? 0, 'bio' => $data['bio'] ?? null];
            if ($photoPath !== null) $profile['photo_path'] = $photoPath;
            DB::table('teachers_profiles')->updateOrInsert(['user_id' => $teacher->id], $profile);
        });
        return back()->with('success', 'تم حفظ تعديلات الملف الشخصي.');
    }
}