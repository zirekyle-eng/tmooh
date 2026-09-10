<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminAcademicsController extends Controller
{
    public function index(): View
    {
        $grades = DB::table('grades')->orderBy('sort_order')->get();
        $teachers = DB::table('users')
            ->where('role', 'teacher')
            ->where('status', 'active')
            ->orderBy('full_name')
            ->get(['id', 'full_name']);
        $subjects = DB::table('subjects as s')->join('grades as g', 'g.id', '=', 's.grade_id')->orderBy('g.sort_order')->orderBy('s.name')->select('s.*', 'g.name as grade_name')->get();

        return view('admin.academics', compact('grades', 'teachers', 'subjects'));
    }

    public function storeGrade(Request $request): RedirectResponse
    {
        $data = $request->validate(['name' => ['required', 'string', 'max:100'], 'sort_order' => ['nullable', 'integer']]);
        DB::table('grades')->insert(['name' => $data['name'], 'sort_order' => $data['sort_order'] ?? 0]);

        return back()->with('success', 'تمت إضافة الصف.');
    }

    public function storeSubject(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'grade_id' => ['required', 'integer', 'exists:grades,id'],
            'name' => ['required', 'string', 'max:120'],
            'monthly_fee' => ['nullable', 'numeric', 'min:0'],
            'description' => ['nullable', 'string'],
            'market_id' => ['required', 'integer', 'exists:markets,id'],
            'tawjihi_branch' => ['required', 'in:general,scientific,literary,sharia,entrepreneurship,vocational'],
            'enrollment_term' => ['required', 'in:full_year,first,second'],
            'sessions_per_week' => ['required', 'integer', 'min:1'],
            'total_hours' => ['nullable', 'numeric', 'min:0'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'free_preview_url' => ['nullable', 'url', 'max:500'],
            'unit_plan' => ['nullable', 'string'],
            'make_up_policy' => ['nullable', 'string'],
            'delivery_type' => ['required', 'in:live,recorded'],
            'recorded_lectures_url' => ['nullable', 'url', 'max:500', 'required_if:delivery_type,recorded'],
            'primary_teacher_id' => ['nullable', 'integer', 'exists:users,id'],
            'image' => ['nullable', 'image', 'mimes:jpeg,jpg,png,webp', 'max:4096'],
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('uploads/subjects', 'public');
        }

        DB::table('subjects')->insert([
            'grade_id' => $data['grade_id'], 'market_id' => $data['market_id'], 'name' => $data['name'],
            'description' => $data['description'] ?? null, 'monthly_fee' => $data['monthly_fee'] ?? 0,
            'image_path' => $imagePath ? 'storage/' . $imagePath : null,
            'status' => 'active', 'tawjihi_branch' => $data['tawjihi_branch'], 'enrollment_term' => $data['enrollment_term'],
            'sessions_per_week' => $data['sessions_per_week'], 'total_hours' => $data['total_hours'] ?? null,
            'start_date' => $data['start_date'] ?? null, 'end_date' => $data['end_date'] ?? null,
            'free_preview_url' => $data['free_preview_url'] ?? null, 'unit_plan' => $data['unit_plan'] ?? null,
            'make_up_policy' => $data['make_up_policy'] ?? null, 'delivery_type' => $data['delivery_type'],
            'recorded_lectures_url' => $data['recorded_lectures_url'] ?? null,
            'primary_teacher_id' => $data['primary_teacher_id'] ?? null,
        ]);

        return back()->with('success', 'تمت إضافة المادة.');
    }
}