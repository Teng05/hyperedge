<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\OtpVerification;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class RegisterController extends Controller
{
    public function showForm()
    {
        return view('auth.register');
    }

    // Step 1: Validate form, send OTP
    public function sendOtp(Request $request)
    {
        $request->validate([
            'first_name'       => 'required|string|max:100',
            'last_name'        => 'required|string|max:100',
            'email'            => 'required|email|unique:users,email',
            'birthday'         => 'required|date',
            'contact_number'   => 'required|string|max:20',
            'affiliation_type' => 'required|string',
            'affiliation_name' => 'required|string|max:255',
            'password'         => 'required|min:8|confirmed',
        ]);

        // Store form data in session
        session(['register_data' => $request->except('password_confirmation', '_token')]);

        // Generate 6-digit OTP
        $otp = str_pad(random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // Delete old OTPs for this email
        OtpVerification::where('email', $request->email)->delete();

        OtpVerification::create([
            'email'      => $request->email,
            'otp_code'   => $otp,
            'expires_at' => now()->addMinutes(10),
        ]);

        // Send OTP email
        Mail::raw("Your HyperEdge Academy OTP code is: {$otp}\n\nThis code expires in 10 minutes.", function ($message) use ($request, $otp) {
            $message->to($request->email)
                    ->subject('HyperEdge Academy — Email Verification OTP');
        });

        return redirect()->route('otp.show')->with('email', $request->email);
    }

    // Step 2: Show OTP form
    public function showOtp()
    {
        if (!session('register_data')) {
            return redirect()->route('register');
        }
        return view('auth.otp');
    }

    // Step 3: Verify OTP and create account
    public function verifyOtp(Request $request)
    {
        $request->validate(['otp_code' => 'required|string|size:6']);

        $data  = session('register_data');
        $email = $data['email'];

        $otp = OtpVerification::where('email', $email)
                              ->where('otp_code', $request->otp_code)
                              ->where('is_used', false)
                              ->first();

        if (!$otp || $otp->isExpired()) {
            return back()->withErrors(['otp_code' => 'Invalid or expired OTP. Please try again.']);
        }

        $otp->update(['is_used' => true]);

        $user = User::create([
            'first_name'       => $data['first_name'],
            'last_name'        => $data['last_name'],
            'email'            => $data['email'],
            'password'         => Hash::make($data['password']),
            'birthday'         => $data['birthday'],
            'contact_number'   => $data['contact_number'],
            'affiliation_type' => $data['affiliation_type'],
            'affiliation_name' => $data['affiliation_name'],
            'role'             => 'student',
            'email_verified'   => true,
            'email_verified_at'=> now(),
        ]);

        session()->forget('register_data');

        auth()->login($user);

        return redirect()->route('student.dashboard')->with('success', 'Account created! Welcome to HyperEdge Academy.');
    }
}
