<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = User::where('role', 'teacher')->latest()->get();
        return view('admin.teachers.index', compact('teachers'));
    }

    public function create()
    {
        return view('admin.teachers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name'  => 'required|string|max:100',
            'email'      => 'required|email|unique:users,email',
        ]);

        $tempPassword = Str::random(10);

        $teacher = User::create([
            'first_name'    => $request->first_name,
            'last_name'     => $request->last_name,
            'email'         => $request->email,
            'password'      => Hash::make($tempPassword),
            'role'          => 'teacher',
            'email_verified'=> true,
            'email_verified_at' => now(),
            'is_active'     => true,
        ]);

        // Send credentials via email
        \Mail::raw(
            "Hello {$teacher->full_name},\n\nYour HyperEdge Academy facilitator account has been created.\n\nEmail: {$teacher->email}\nTemporary Password: {$tempPassword}\n\nPlease change your password after logging in.",
            function ($m) use ($teacher) {
                $m->to($teacher->email)->subject('HyperEdge Academy — Facilitator Account Created');
            }
        );

        return redirect()->route('admin.teachers.index')->with('success', 'Facilitator account created and credentials sent to their email.');
    }

    public function toggle($id)
    {
        $teacher = User::where('role', 'teacher')->findOrFail($id);
        $teacher->update(['is_active' => !$teacher->is_active]);
        return back()->with('success', 'Facilitator status updated.');
    }

    public function destroy($id)
    {
        User::where('role', 'teacher')->findOrFail($id)->delete();
        return back()->with('success', 'Facilitator removed.');
    }
}
