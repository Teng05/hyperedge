<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Certificate;
use App\Models\Module;
use App\Models\Quiz;
use App\Models\QuizAttempt;
use App\Models\StudentModuleProgress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class QuizController extends Controller
{
    public function show($quizId)
    {
        $quiz = Quiz::with('questions')->findOrFail($quizId);
        $user = Auth::user();

        // Implement session cache for question order to prevent cheating via page refresh
        $sessionKey = "quiz_questions_{$quizId}";
        
        if (session()->has($sessionKey)) {
            $questionIds = session()->get($sessionKey);
            $questions = $quiz->questions->whereIn('id', $questionIds)->sortBy(function($q) use ($questionIds) {
                return array_search($q->id, $questionIds);
            });
        } else {
            // Pull a subset of 5-10 questions from the pool of questions
            $subsetCount = min(10, max(5, $quiz->questions->count()));
            if ($quiz->questions->count() > 0) {
                $questions = $quiz->questions->shuffle()->take($subsetCount);
            } else {
                $questions = collect();
            }
            $questionIds = $questions->pluck('id')->toArray();
            session()->put($sessionKey, $questionIds);
        }

        $attemptCount = QuizAttempt::where('user_id', $user->id)
                                    ->where('quiz_id', $quizId)
                                    ->count();

        return view('student.quiz', compact('quiz', 'questions', 'attemptCount'));
    }

    public function submit(Request $request, $quizId)
    {
        $quiz  = Quiz::with('questions')->findOrFail($quizId);
        $user  = Auth::user();
        $score = 0;

        $sessionKey = "quiz_questions_{$quizId}";
        $questionIds = session()->get($sessionKey);

        if ($questionIds) {
            $questions = $quiz->questions->whereIn('id', $questionIds);
        } else {
            $questions = $quiz->questions;
        }

        $totalPoints = 0;
        foreach ($questions as $question) {
            $answer = $request->input("answers.{$question->id}");
            if ($answer === $question->correct_answer) {
                $score += $question->points;
            }
            $totalPoints += $question->points;
        }

        $isViolation = $request->input('is_violation') || $request->input('integrity_violation') ? true : false;
        $passed = $isViolation ? false : ($score >= $quiz->passing_score);
        $attemptCount = QuizAttempt::where('user_id', $user->id)->where('quiz_id', $quizId)->count();

        QuizAttempt::create([
            'user_id'        => $user->id,
            'quiz_id'        => $quizId,
            'score'          => $score,
            'total_points'   => $totalPoints, // Grade based on the generated subset total points
            'passed'         => $passed,
            'is_violation'   => $isViolation,
            'attempt_number' => $attemptCount + 1,
            'started_at'     => now(),
            'submitted_at'   => now(),
        ]);

        // Forget the session question set to force fresh random questions next attempt
        session()->forget($sessionKey);

        if ($passed) {
            if ($quiz->type === 'module_assessment' && $quiz->module_id) {
                $this->unlockNextModule($user->id, $quiz->module_id);
            }

            if ($quiz->type === 'final_exam') {
                $this->issueCertificate($user);
            }
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'score' => $score,
                'passed' => $passed,
                'is_violation' => $isViolation,
                'total' => $totalPoints,
                'type' => $quiz->type,
                'certificate_url' => route('student.certificate'),
                'dashboard_url' => route('student.dashboard'),
                'retake_url' => route('student.quiz.show', $quizId),
            ]);
        }

        return redirect()->route('student.quiz.result', $quizId)
                         ->with(['score' => $score, 'passed' => $passed, 'total' => $totalPoints, 'is_violation' => $isViolation]);
    }

    public function result($quizId)
    {
        $quiz  = Quiz::findOrFail($quizId);
        $score = session('score');
        $passed = session('passed');
        $total  = session('total');
        $isViolation = session('is_violation');

        if ($score === null) {
            $latest = QuizAttempt::where('user_id', Auth::id())
                                 ->where('quiz_id', $quizId)
                                 ->orderBy('id', 'desc')
                                 ->first();
            if ($latest) {
                $score  = $latest->score;
                $passed = $latest->passed;
                $total  = $latest->total_points;
                $isViolation = $latest->is_violation;
            } else {
                $score  = 0;
                $passed = false;
                $total  = 0;
                $isViolation = false;
            }
        }

        return view('student.quiz-result', compact('quiz', 'score', 'passed', 'total', 'isViolation'));
    }

    private function unlockNextModule($userId, $currentModuleId)
    {
        $current = Module::find($currentModuleId);

        // Mark current as completed
        StudentModuleProgress::where('user_id', $userId)
                              ->where('module_id', $currentModuleId)
                              ->update(['is_completed' => true, 'completed_at' => now()]);

        // Find and unlock next module
        $next = Module::where('order', '>', $current->order)
                       ->where('is_active', true)
                       ->orderBy('order')
                       ->first();

        if ($next) {
            StudentModuleProgress::updateOrCreate(
                ['user_id' => $userId, 'module_id' => $next->id],
                ['is_unlocked' => true]
            );
        }
    }

    private function issueCertificate($user)
    {
        if ($user->certificate) return; // already issued

        $code = strtoupper(Str::random(3)) . '-' . random_int(100000, 999999);

        $cert = Certificate::create([
            'user_id'          => $user->id,
            'certificate_code' => $code,
            'issued_at'        => now(),
        ]);

        // Send certificate email
        Mail::raw(
            "Congratulations, {$user->full_name}!\n\nYou have successfully passed the HyperEdge Academy HTML Certification.\n\nYour Certificate Code: {$code}\n\nKeep learning!",
            function ($message) use ($user) {
                $message->to($user->email)
                        ->subject('🎓 HyperEdge Academy — Your Certificate is Ready!');
            }
        );

        $cert->update(['email_sent' => true]);
    }
}
