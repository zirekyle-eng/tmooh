<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;

class PublicController extends Controller
{
    public function home(): View
    {
        $subjects = Subject::query()->where('status', 'active')->orderBy('name')->limit(6)->get();

        return view('public.home', compact('subjects'));
    }

    public function catalog(): View
    {
        $subjects = Subject::query()->with('grade')->where('status', 'active')->orderBy('name')->get();

        return view('public.catalog', compact('subjects'));
    }

    public function subject(int $id): View
    {
        $subject = Subject::query()->with('grade')->where('id', $id)->where('status', 'active')->firstOrFail();

        return view('public.subject', compact('subject'));
    }

    public function teachers(): View
    {
        $teachers = User::query()
            ->select('users.id', 'users.full_name', 'teachers_profiles.specialization', 'teachers_profiles.years_experience', 'teachers_profiles.bio', 'teachers_profiles.photo_path')
            ->leftJoin('teachers_profiles', 'teachers_profiles.user_id', '=', 'users.id')
            ->where('users.role', 'teacher')
            ->where('users.status', 'active')
            ->orderBy('users.full_name')
            ->get();

        return view('public.teachers', compact('teachers'));
    }

    public function teacher(int $id): View
    {
        $teacher = User::query()
            ->select('users.id', 'users.full_name', 'teachers_profiles.specialization', 'teachers_profiles.years_experience', 'teachers_profiles.bio', 'teachers_profiles.photo_path', 'teachers_profiles.qualifications', 'teachers_profiles.verification_source')
            ->leftJoin('teachers_profiles', 'teachers_profiles.user_id', '=', 'users.id')
            ->where('users.id', $id)
            ->where('users.role', 'teacher')
            ->where('users.status', 'active')
            ->firstOrFail();

        $subjects = Subject::query()
            ->select('subjects.name', 'grades.name as grade')
            ->join('class_schedules', 'class_schedules.subject_id', '=', 'subjects.id')
            ->join('grades', 'grades.id', '=', 'subjects.grade_id')
            ->where('class_schedules.teacher_id', $id)
            ->where('class_schedules.status', 'active')
            ->distinct()
            ->orderBy('subjects.name')
            ->get();

        return view('public.teacher', compact('teacher', 'subjects'));
    }

    public function homeTeachers(): JsonResponse
    {
        $teachers = User::query()
            ->select('users.id', 'users.full_name', 'teachers_profiles.specialization', 'teachers_profiles.bio', 'teachers_profiles.photo_path')
            ->leftJoin('teachers_profiles', 'teachers_profiles.user_id', '=', 'users.id')
            ->where('users.role', 'teacher')
            ->where('users.status', 'active')
            ->orderBy('users.full_name')
            ->limit(6)
            ->get();

        return response()->json(['ok' => true, 'teachers' => $teachers]);
    }

    public function page(string $page): View
    {
        abort_unless(in_array($page, ['about', 'contact', 'policies', 'pricing'], true), 404);

        return view('public.' . $page);
    }
}