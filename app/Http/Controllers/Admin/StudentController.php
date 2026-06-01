<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Voucher;
use App\Models\Module;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Carbon\Carbon;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'student')->with(['voucher', 'moduleProgress', 'quizAttempts']);

        // Search Filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Date-Range Filters (Registration Date)
        $startDate = null;
        $endDate = null;

        if ($request->filled('start_date')) {
            $startDate = Carbon::parse($request->start_date)->startOfDay();
            $query->where('created_at', '>=', $startDate);
        }

        if ($request->filled('end_date')) {
            $endDate = Carbon::parse($request->end_date)->endOfDay();
            $query->where('created_at', '<=', $endDate);
        }

        $students = $query->latest()->get();

        // ── RELATIONAL ANALYTICS & METRICS AGGREGATES ──
        $totalStudents = $students->count();
        
        $activeVouchersCount = Voucher::where('is_approved', true)
            ->when($startDate, fn($q) => $q->where('approved_at', '>=', $startDate))
            ->when($endDate, fn($q) => $q->where('approved_at', '<=', $endDate))
            ->count();

        $totalModulesCount = Module::where('is_active', true)->count();
        
        // Calculate average progress and quiz attempt aggregates
        $completedModulesCount = 0;
        $totalQuizAttempts = 0;
        $passedQuizAttempts = 0;

        foreach ($students as $student) {
            $studentCompleted = $student->moduleProgress->where('is_completed', true)->count();
            $student->completed_modules_count = $studentCompleted;
            $student->total_modules_count = $totalModulesCount;
            $student->progress_percent = $totalModulesCount > 0 ? round(($studentCompleted / $totalModulesCount) * 100) : 0;
            
            $completedModulesCount += $studentCompleted;
            
            $attempts = $student->quizAttempts;
            $totalQuizAttempts += $attempts->count();
            $passedQuizAttempts += $attempts->where('passed', true)->count();
        }

        $avgCompletionRate = $totalStudents > 0 && $totalModulesCount > 0 
            ? round((($completedModulesCount / ($totalStudents * $totalModulesCount)) * 100), 1)
            : 0;

        $quizPassRate = $totalQuizAttempts > 0
            ? round(($passedQuizAttempts / $totalQuizAttempts) * 100, 1)
            : 0;

        return view('admin.students.index', compact(
            'students',
            'totalStudents',
            'activeVouchersCount',
            'avgCompletionRate',
            'totalQuizAttempts',
            'quizPassRate',
            'totalModulesCount'
        ));
    }

    public function edit($id)
    {
        $student = User::where('role', 'student')->findOrFail($id);
        return view('admin.students.edit', compact('student'));
    }

    public function update(Request $request, $id)
    {
        $student = User::where('role', 'student')->findOrFail($id);

        $request->validate([
            'first_name'       => 'required|string|max:100',
            'last_name'        => 'required|string|max:100',
            'email'            => 'required|email|unique:users,email,' . $id,
            'birthday'         => 'required|date',
            'contact_number'   => 'required|string|max:20',
            'affiliation_type' => 'required|string',
            'affiliation_name' => 'required|string|max:255',
            'is_active'        => 'required|boolean',
        ]);

        $student->update([
            'first_name'       => $request->first_name,
            'last_name'        => $request->last_name,
            'email'            => $request->email,
            'birthday'         => $request->birthday,
            'contact_number'   => $request->contact_number,
            'affiliation_type' => $request->affiliation_type,
            'affiliation_name' => $request->affiliation_name,
            'is_active'        => $request->is_active,
        ]);

        return redirect()->route('admin.students.index')
                         ->with('success', 'Student details updated successfully.');
    }
}
