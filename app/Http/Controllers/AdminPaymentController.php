<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class AdminPaymentController extends Controller
{
    public function index(Request $request): View
    {
        $filter = in_array($request->query('status'), ['pending', 'approved', 'rejected'], true)
            ? $request->query('status')
            : null;

        $payments = DB::table('payments as p')
            ->join('users as u', 'u.id', '=', 'p.student_id')
            ->leftJoin('enrollments as e', 'e.id', '=', 'p.enrollment_id')
            ->leftJoin('subjects as s', 's.id', '=', 'e.subject_id')
            ->when($filter, fn ($query) => $query->where('p.status', $filter))
            ->orderByDesc('p.created_at')
            ->select('p.*', 'u.full_name', 'u.phone', 's.name as subject_name')
            ->get();

        $counts = collect(['pending', 'approved', 'rejected'])
            ->mapWithKeys(fn ($status) => [$status => DB::table('payments')->where('status', $status)->count()]);

        return view('admin.payments', compact('payments', 'counts', 'filter'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'payment_id' => ['required', 'integer', 'exists:payments,id'],
            'action' => ['required', 'in:approve,reject'],
        ]);

        DB::transaction(function () use ($data, $request): void {
            $payment = DB::table('payments')->where('id', $data['payment_id'])->lockForUpdate()->first();
            abort_unless($payment && $payment->status === 'pending', 409, 'هذه الدفعة تمت مراجعتها مسبقًا.');

            if ($data['action'] === 'reject') {
                DB::table('payments')->where('id', $payment->id)->update([
                    'status' => 'rejected',
                    'reviewed_by' => $request->user()->id,
                ]);
                return;
            }

            DB::table('payments')->where('id', $payment->id)->update([
                'status' => 'approved',
                'paid_at' => now(),
                'reviewed_by' => $request->user()->id,
            ]);
            DB::table('enrollments')->where('id', $payment->enrollment_id)->update([
                'status' => 'active',
                'starts_on' => DB::raw('COALESCE(starts_on, CURDATE())'),
            ]);
            DB::statement('INSERT IGNORE INTO student_schedule (student_id, schedule_id, enrollment_id, active_from) SELECT ?, id, ?, CURDATE() FROM class_schedules WHERE subject_id = (SELECT subject_id FROM enrollments WHERE id = ?) AND status = "active"', [$payment->student_id, $payment->enrollment_id, $payment->enrollment_id]);
        });

        return back()->with('success', $data['action'] === 'approve' ? 'تم اعتماد الدفعة وتفعيل المادة.' : 'تم رفض الدفعة.');
    }
}