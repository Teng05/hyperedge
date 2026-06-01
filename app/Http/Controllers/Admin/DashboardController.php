<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\User;
use App\Models\Voucher;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Core KPIs (Overall)
        $totalStudents   = User::where('role', 'student')->count();
        $totalTeachers   = User::where('role', 'teacher')->count();
        $totalVouchers   = Voucher::count();
        $pendingVouchers = Voucher::where('is_paid', true)->where('is_approved', false)->count();
        $totalCerts      = Certificate::count();
        $recentStudents  = User::where('role', 'student')->latest()->take(5)->get();
        $recentVouchers  = Voucher::with('assignedTo')->latest()->take(6)->get();

        // ─── ADVANCED ANALYTICS ENGINE ──────────────────────────────────────────
        $query = QuizAttempt::with(['user', 'quiz.module']);

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

        // Calculate dynamic analytics on the filtered subset
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
        $quizzes = Quiz::orderBy('title')->get();

        return view('admin.dashboard', compact(
            'totalStudents', 'totalTeachers', 'totalVouchers',
            'pendingVouchers', 'totalCerts',
            'recentStudents', 'recentVouchers',
            'attempts', 'quizzes', 'filteredCount', 'averagePct', 'passingRate'
        ));
    }
}