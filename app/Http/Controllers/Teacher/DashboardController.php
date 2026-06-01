<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $teacher       = Auth::user();
        $modules       = Module::where('teacher_id', $teacher->id)->withCount('lessons')->orderBy('order')->get();
        $totalStudents = User::where('role', 'student')->count();
        
        $moduleIds     = $modules->pluck('id');
        $teacherQuizzes = Quiz::whereIn('module_id', $moduleIds)->orWhere('type', 'final_exam')->get();
        $quizIds       = $teacherQuizzes->pluck('id');

        $totalQuizzes  = Quiz::whereIn('module_id', $moduleIds)->count();

        // ─── CLASSROOM ANALYTICS ENGINE ─────────────────────────────────────────
        $query = QuizAttempt::whereIn('quiz_id', $quizIds)->with(['user', 'quiz.module']);

        // 1. Date Range Filtering
        if ($request->filled('date_range')) {
            if ($request->date_range === '7_days') {
                $query->where('created_at', '>=', now()->subDays(7));
            } elseif ($request->date_range === '30_days') {
                $query->where('created_at', '>=', now()->subDays(30));
            }
        }

        // 2. Target Quiz Filtering
        if ($request->filled('quiz_id')) {
            $query->where('quiz_id', $request->quiz_id);
        }

        // 3. Score Outcome / Performance Sorting
        if ($request->filled('score_filter')) {
            if ($request->score_filter === 'passed') {
                $query->where('passed', true);
            } elseif ($request->score_filter === 'failed') {
                $query->where('passed', false);
            }
        }

        // Calculate dynamic classroom analytics
        $filteredCount = (clone $query)->count();
        
        $averagePct = round((clone $query)->selectRaw('AVG((score / total_points) * 100) as avg_pct')->value('avg_pct') ?? 0, 1);
        
        $passedCount = (clone $query)->where('passed', true)->count();
        $passingRate = $filteredCount > 0 ? round(($passedCount / $filteredCount) * 100, 1) : 0;

        // Apply sorts and paginate
        if ($request->score_filter === 'high_score') {
            $query->orderBy('score', 'desc');
        } elseif ($request->score_filter === 'low_score') {
            $query->orderBy('score', 'asc');
        } else {
            $query->latest();
        }

        $attempts = $query->paginate(8)->withQueryString();

        return view('teacher.dashboard', compact(
            'modules', 'totalStudents', 'totalQuizzes', 'teacher',
            'attempts', 'teacherQuizzes', 'filteredCount', 'averagePct', 'passingRate'
        ));
    }
}
