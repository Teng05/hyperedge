<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Module;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function create($moduleId)
    {
        $module = Module::where('teacher_id', Auth::id())->findOrFail($moduleId);
        return view('teacher.quiz.create', compact('module'));
    }

    public function store(Request $request, $moduleId)
    {
        $module = Module::where('teacher_id', Auth::id())->findOrFail($moduleId);

        $request->validate([
            'title'         => 'required|string|max:255',
            'type'          => 'required|in:module_assessment,final_exam',
            'passing_score' => 'required|integer|min:1',
            'total_points'  => 'required|integer|min:1',
            'randomize'     => 'nullable|boolean',
        ]);

        $quiz = Quiz::updateOrCreate(
            ['module_id' => $moduleId],
            [
                'title'         => $request->title,
                'type'          => $request->type,
                'passing_score' => $request->passing_score,
                'total_points'  => $request->total_points,
                'randomize'     => $request->boolean('randomize'),
                'show_answers'  => false,
            ]
        );

        return redirect()->route('teacher.quiz.questions', $quiz->id)
                         ->with('success', 'Quiz created! Now add questions.');
    }

    public function showQuestions($quizId)
    {
        $quiz = Quiz::with('questions', 'module')->findOrFail($quizId);
        return view('teacher.quiz.questions', compact('quiz'));
    }

    public function addQuestion(Request $request, $quizId)
    {
        $quiz = Quiz::findOrFail($quizId);

        $request->validate([
            'question_text'  => 'required|string',
            'choice_a'       => 'required|string',
            'choice_b'       => 'required|string',
            'choice_c'       => 'required|string',
            'choice_d'       => 'required|string',
            'correct_answer' => 'required|in:a,b,c,d',
            'points'         => 'required|integer|min:1',
        ]);

        Question::create([
            'quiz_id'        => $quizId,
            'question_text'  => $request->question_text,
            'choice_a'       => $request->choice_a,
            'choice_b'       => $request->choice_b,
            'choice_c'       => $request->choice_c,
            'choice_d'       => $request->choice_d,
            'correct_answer' => $request->correct_answer,
            'points'         => $request->points,
        ]);

        return redirect()->route('teacher.quiz.questions', $quizId)->with('success', 'Question added!');
    }

    public function deleteQuestion($questionId)
    {
        Question::findOrFail($questionId)->delete();
        return back()->with('success', 'Question deleted.');
    }
}
