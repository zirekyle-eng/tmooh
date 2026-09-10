<?php

namespace App\Http\Controllers;

use App\Models\Grade;
use App\Models\Subject;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    public function index(): View
    {
        $subjects = Subject::query()
            ->with('grade')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('subjects.index', compact('subjects'));
    }

    public function dashboard(): View
    {
        $enrollments = DB::table('enrollments as e')
            ->join('subjects as s', 's.id', '=', 'e.subject_id')
            ->where('e.student_id', Auth::id())
            ->orderByDesc('e.created_at')
            ->select('e.id', 's.name as subject_name', 'e.status')
            ->get();

        $classes = DB::table('student_schedule as ss')
            ->join('class_schedules as cs', 'cs.id', '=', 'ss.schedule_id')
            ->join('subjects as s', 's.id', '=', 'cs.subject_id')
            ->join('users as u', 'u.id', '=', 'cs.teacher_id')
            ->where('ss.student_id', Auth::id())
            ->where('cs.status', 'active')
            ->where(function ($query): void {
                $query->whereNull('ss.active_until')->orWhere('ss.active_until', '>=', now()->toDateString());
            })
            ->orderBy('cs.day_of_week')->orderBy('cs.starts_at')
            ->select('s.name as subject_name', 'u.full_name as teacher_name', 'cs.day_of_week', 'cs.starts_at', 'cs.ends_at', 'cs.viva_z_join_url')
            ->get();

        $payments = DB::table('payments as p')
            ->leftJoin('enrollments as e', 'e.id', '=', 'p.enrollment_id')
            ->leftJoin('subjects as s', 's.id', '=', 'e.subject_id')
            ->where('p.student_id', Auth::id())
            ->orderByDesc('p.created_at')
            ->limit(10)
            ->select('p.amount', 'p.status', 's.name as subject_name')
            ->get();

        return view('dashboard', compact('enrollments', 'classes', 'payments'));
    }

    public function enroll(Request $request): RedirectResponse
    {
        $data = $request->validate(['subject_id' => ['required', 'integer', 'exists:subjects,id']]);
        $subject = Subject::where('id', $data['subject_id'])->where('status', 'active')->firstOrFail();

        $alreadyExists = DB::table('enrollments')
            ->where('student_id', Auth::id())
            ->where('subject_id', $subject->id)
            ->exists();

        if (!$alreadyExists) {
            DB::table('enrollments')->insert([
                'student_id' => Auth::id(),
                'subject_id' => $subject->id,
                'starts_on' => now()->toDateString(),
                'status' => 'pending',
            ]);
        }

        return redirect()->route('dashboard')->with('success', 'تم حفظ طلب التسجيل. أكمل الدفع من لوحة الطالب.');
    }
}