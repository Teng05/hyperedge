<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class VoucherController extends Controller
{
    public function index()
    {
        $vouchers = Voucher::with(['assignedTo', 'generator'])->latest()->get();
        $students = User::where('role', 'student')->get();
        return view('admin.vouchers.index', compact('vouchers', 'students'));
    }

    public function generate(Request $request)
    {
        $request->validate([
            'assigned_to' => 'nullable|exists:users,id',
            'quantity'    => 'required|integer|min:1|max:50',
        ]);

        $codes = [];
        for ($i = 0; $i < $request->quantity; $i++) {
            $code = strtoupper(Str::random(4)) . '-' . strtoupper(Str::random(4));

            Voucher::create([
                'code'         => $code,
                'generated_by' => Auth::id(),
                'assigned_to'  => $request->assigned_to ?: null,
            ]);

            $codes[] = $code;
        }

        // If assigned to a specific student, email them
        if ($request->assigned_to) {
            $student  = User::find($request->assigned_to);
            $codeList = implode(', ', $codes);

            \Mail::raw(
                "Hello {$student->full_name},\n\nYour HyperEdge Academy exam voucher code(s):\n\n{$codeList}\n\nUse this code to start your certification exam.",
                function ($m) use ($student) {
                    $m->to($student->email)->subject('HyperEdge Academy — Your Exam Voucher');
                }
            );
        }

        return redirect()->route('admin.vouchers.index')
                         ->with('success', count($codes) . ' voucher(s) generated.');
    }

    public function approve($id)
    {
        $voucher = Voucher::findOrFail($id);
        $voucher->update([
            'is_approved' => true,
            'approved_at' => now(),
        ]);

        // Email the student their voucher code
        if ($voucher->assignedTo) {
            \Mail::raw(
                "Hello {$voucher->assignedTo->full_name},\n\nYour payment has been approved!\n\nYour voucher code is: {$voucher->code}\n\nYou can now start your HyperEdge Academy certification modules.",
                function ($m) use ($voucher) {
                    $m->to($voucher->assignedTo->email)
                      ->subject('HyperEdge Academy — Payment Approved! Your Voucher is Ready');
                }
            );
        }

        return back()->with('success', 'Voucher approved and student notified.');
    }

    public function destroy($id)
    {
        Voucher::findOrFail($id)->delete();
        return back()->with('success', 'Voucher deleted.');
    }
}