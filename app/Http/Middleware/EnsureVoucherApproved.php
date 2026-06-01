<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EnsureVoucherApproved
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user && $user->role === 'student') {
            $voucher = $user->voucher;

            if (!$voucher || !$voucher->is_approved) {
                // If it's an AJAX/JSON request, return JSON error
                if ($request->expectsJson()) {
                    return response()->json([
                        'error' => 'You must have an approved voucher to access this resource.'
                    ], 403);
                }

                return redirect()->route('student.voucher')
                                 ->with('error', 'You must have an approved voucher to access certification pathways. Please submit payment or redeem a code below.');
            }
        }

        return $next($request);
    }
}
