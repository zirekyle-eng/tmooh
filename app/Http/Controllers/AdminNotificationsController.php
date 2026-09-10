<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminNotificationsController extends Controller
{
    public function index(): View
    {
        $notifications = DB::table('admin_notifications')->orderByDesc('created_at')->limit(100)->get();
        $unread = DB::table('admin_notifications')->where('is_read', 0)->count();

        return view('admin.notifications', compact('notifications', 'unread'));
    }

    public function read(Request $request): RedirectResponse
    {
        if ($request->boolean('all')) {
            DB::table('admin_notifications')->where('is_read', 0)->update(['is_read' => 1]);
        } elseif ($request->filled('id')) {
            DB::table('admin_notifications')->where('id', $request->integer('id'))->update(['is_read' => 1]);
        }

        return back();
    }
}