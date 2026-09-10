<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class AdminApplicationsController extends Controller
{
    public function index(): View
    {
        $applications = DB::table('teacher_applications')->orderByDesc('created_at')->get();

        return view('admin.applications', compact('applications'));
    }
}