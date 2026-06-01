<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Voucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoucherController extends Controller
{
    /**
     * Show the voucher page.
     */
    public function index()
    {
        $voucher = Auth::user()->voucher;
        return view('student.voucher', compact('voucher'));
    }

    /**
     * Redeem a voucher code.
     *
     * Admin pre-generates codes. A code is claimable when:
     *   - it matches the logged-in student's assigned_to, OR
     *   - assigned_to is null (unassigned / open code)
     * AND it is not yet approved.
     */
    public function redeem(Request $request)
    {
        $request->validate([
            'code' => ['required', 'string'],
        ]);

        $user = Auth::user();

        if ($user->voucher && $user->voucher->is_approved) {
            return back()->withErrors(['code' => 'You already have an active voucher.']);
        }

        $voucher = Voucher::where('code', strtoupper(trim($request->code)))
                          ->where('is_approved', false)
                          ->where(function ($q) use ($user) {
                              $q->where('assigned_to', $user->id)
                                ->orWhereNull('assigned_to');
                          })
                          ->first();

        if (!$voucher) {
            return back()->withErrors(['code' => 'Invalid, already used, or unrecognized voucher code.']);
        }

        $voucher->update([
            'assigned_to' => $user->id,
            'is_approved' => true,
            'approved_at' => now(),
        ]);

        return redirect()->route('student.voucher')
                         ->with('success', 'Voucher redeemed! You now have full module access.');
    }

    /**
     * Manual payment declaration.
     *
     * The student's voucher is pre-assigned by admin (assigned_to = user->id).
     * Student clicks "I have paid" → sets is_paid = true → admin approves.
     *
     * Your Voucher schema has no payment_proof column, so we only toggle is_paid.
     */
    public function markPaid(Request $request)
    {
        $user    = Auth::user();
        $voucher = $user->voucher;

        if (!$voucher) {
            return back()->withErrors(['paid' => 'No voucher is linked to your account. Contact your facilitator or admin.']);
        }

        if ($voucher->is_approved) {
            return back()->with('success', 'Your voucher is already approved.');
        }

        $request->validate([
            'payment_proof' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:10240', // 10MB Max Image
            'notes'         => 'nullable|string|max:1000',
        ]);

        $path = null;
        if ($request->hasFile('payment_proof')) {
            $path = $request->file('payment_proof')->store('payment_proofs', 'public');
        }

        $voucher->update([
            'is_paid'       => true,
            'payment_proof' => $path,
            'notes'         => $request->notes,
        ]);

        return redirect()->route('student.voucher')
                         ->with('success', 'Payment proof submitted! An admin will review and approve your access shortly.');
    }
}