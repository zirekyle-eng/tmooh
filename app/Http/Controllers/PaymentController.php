<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class PaymentController extends Controller
{
    public function create(Request $request): View
    {
        $enrollment = $this->pendingEnrollment((int) $request->query('enrollment_id'));
        abort_unless($enrollment, 404, 'طلب التسجيل غير متاح في منطقتك.');

        $methods = [
            'bank_of_palestine' => ['بنك فلسطين', 'حوّل المبلغ إلى حساب الأكاديمية وأرفق إشعار التحويل.'],
            'bank_transfer' => ['تحويل بنكي', 'حوّل المبلغ ثم أرفق الإيصال.'],
            'barq' => ['برق', 'ادفع من تطبيق برق وأرفق الإيصال.'],
        ];

        if ($enrollment->market_code === 'egypt') {
            $methods['vodafone_cash'] = ['Vodafone Cash', 'حوّل إلى محفظة الأكاديمية وأرفق الإيصال.'];
            $methods['instapay'] = ['Instapay', 'حوّل عبر Instapay وأرفق الإيصال.'];
        }

        return view('payment.create', [
            'enrollment' => $enrollment,
            'currency' => $enrollment->market_code === 'egypt' ? 'EGP' : 'ILS',
            'methods' => $methods,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $enrollment = $this->pendingEnrollment((int) $request->input('enrollment_id'));
        abort_unless($enrollment, 404, 'طلب التسجيل غير متاح في منطقتك.');

        $data = $request->validate([
            'enrollment_id' => ['required', 'integer'],
            'method' => ['required', 'in:bank_of_palestine,bank_transfer,barq,vodafone_cash,instapay'],
            'reference' => ['nullable', 'string', 'max:120'],
            'receipt' => ['required', 'file', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ], [
            'receipt.required' => 'صورة إشعار الدفع مطلوبة.',
            'receipt.mimes' => 'ارفع JPG أو PNG أو WebP.',
            'receipt.max' => 'حجم الإيصال يجب ألا يتجاوز 4MB.',
        ]);

        $directory = public_path('uploads/receipts');
        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $extension = $request->file('receipt')->extension();
        $filename = 'receipt_' . bin2hex(random_bytes(10)) . '.' . $extension;
        $request->file('receipt')->move($directory, $filename);

        DB::table('payments')->insert([
            'student_id' => Auth::id(),
            'enrollment_id' => $enrollment->id,
            'amount' => $enrollment->monthly_fee,
            'method' => $data['method'],
            'reference' => $data['reference'] ?? null,
            'receipt_path' => 'public/uploads/receipts/' . $filename,
            'status' => 'pending',
            'created_at' => now(),
        ]);

        return redirect()->route('dashboard')->with('success', 'تم إرسال الدفع وصورة الإيصال للمراجعة.');
    }

    private function pendingEnrollment(int $id): ?object
    {
        return DB::table('enrollments')
            ->join('subjects', 'subjects.id', '=', 'enrollments.subject_id')
            ->join('markets', 'markets.id', '=', 'subjects.market_id')
            ->where('enrollments.id', $id)
            ->where('enrollments.student_id', Auth::id())
            ->where('enrollments.status', 'pending')
            ->whereColumn('subjects.market_id', 'users.market_id')
            ->join('users', 'users.id', '=', 'enrollments.student_id')
            ->select('enrollments.id', 'subjects.name', 'subjects.monthly_fee', 'markets.code as market_code')
            ->first();
    }
}