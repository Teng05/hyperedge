<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\StudentModuleProgress;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user    = Auth::user();
        $modules = Module::where('is_active', true)->orderBy('order')->get();

        // Ensure first module is always unlocked and check if all modules are completed
        $allModulesCompleted = $modules->count() > 0;
        
        foreach ($modules as $index => $module) {
            $progress = StudentModuleProgress::firstOrCreate(
                ['user_id' => $user->id, 'module_id' => $module->id],
                ['is_unlocked' => $index === 0, 'is_completed' => false]
            );
            $module->progress = $progress;
            
            if (!$progress->is_completed) {
                $allModulesCompleted = false;
            }
        }

        $hasVoucher = $user->voucher && $user->voucher->is_approved;
        $certificate = $user->certificate;

        // Fetch final 30-point evaluation quiz if unlocked
        $finalQuiz = null;
        $finalQuizPassed = false;
        
        if ($allModulesCompleted) {
            $finalQuiz = \App\Models\Quiz::where('type', 'final_exam')->first();
            if ($finalQuiz) {
                $finalQuizPassed = \App\Models\QuizAttempt::where('user_id', $user->id)
                    ->where('quiz_id', $finalQuiz->id)
                    ->where('passed', true)
                    ->exists();
            }
        }

        return view('student.dashboard', compact('modules', 'hasVoucher', 'certificate', 'user', 'allModulesCompleted', 'finalQuiz', 'finalQuizPassed'));
    }
}
