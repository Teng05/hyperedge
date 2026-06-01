<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\StudentModuleProgress;
use App\Models\StudentLessonProgress; // Added this missing import to fix the 500 crash
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModuleController extends Controller
{
    public function show($id)
    {
        $user   = Auth::user();
        $module = Module::with(['lessons', 'quiz'])->findOrFail($id);

        $progress = StudentModuleProgress::where('user_id', $user->id)
                                         ->where('module_id', $id)
                                         ->first();

        if (!$progress || !$progress->is_unlocked) {
            return redirect()->route('student.dashboard')
                             ->withErrors(['error' => 'This module is still locked.']);
        }

        // Get lesson completion status
        $completedLessons = StudentLessonProgress::where('user_id', $user->id)
                                                 ->whereIn('lesson_id', $module->lessons->pluck('id'))
                                                 ->where('is_completed', true)
                                                 ->pluck('lesson_id')
                                                 ->toArray();

        return view('student.module', compact('module', 'progress', 'completedLessons'));
    }

    public function completeLesson(Request $request, $lessonId)
    {
        StudentLessonProgress::updateOrCreate(
            ['user_id' => Auth::id(), 'lesson_id' => $lessonId],
            ['is_completed' => true, 'completed_at' => now()]
        );

        return response()->json(['success' => true]);
    }
}