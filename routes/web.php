<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Student;
use App\Http\Controllers\Teacher;
use App\Http\Controllers\Admin;

// Landing
Route::get('/', fn() => view('welcome'));

// ─── AUTH (guest only) ────────────────────────────────────────────────────────
Route::middleware('guest')->group(function () {

    // Login
    Route::get('/login',  [LoginController::class, 'showForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);

    // Register + OTP
    Route::get('/register',         [RegisterController::class, 'showForm'])->name('register');
    Route::post('/register/otp',    [RegisterController::class, 'sendOtp'])->name('register.otp');
    Route::get('/register/verify',  [RegisterController::class, 'showOtp'])->name('otp.show');
    Route::post('/register/verify', [RegisterController::class, 'verifyOtp'])->name('otp.verify');

    // Forgot / Reset Password
    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');

    Route::post('/forgot-password', function (Request $request) {
        $request->validate(['email' => 'required|email']);
        $status = Password::sendResetLink($request->only('email'));
        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', 'Password reset link sent! Check your email.')
            : back()->withErrors(['email' => __($status)]);
    })->name('password.email');

    Route::get('/reset-password/{token}', function (string $token) {
        return view('auth.reset-password', ['token' => $token]);
    })->name('password.reset');

    Route::post('/reset-password', function (Request $request) {
        $request->validate([
            'token'    => 'required',
            'email'    => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill(['password' => bcrypt($password)])->save();
            }
        );
        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Password reset successfully! You can now sign in.')
            : back()->withErrors(['email' => __($status)]);
    })->name('password.update');
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// ─── STUDENT ─────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:student'])->prefix('student')->name('student.')->group(function () {

    Route::get('/dashboard',             [Student\DashboardController::class,  'index'])->name('dashboard');

    // Voucher (Accessible without approved voucher so students can enter codes or upload proofs)
    Route::get('/voucher',               [Student\VoucherController::class,    'index'])->name('voucher');
    Route::post('/voucher/redeem',       [Student\VoucherController::class,    'redeem'])->name('voucher.redeem');
    Route::post('/voucher/paid',         [Student\VoucherController::class,    'markPaid'])->name('voucher.paid');

    // Restricted certification pathways (Requires approved voucher status)
    Route::middleware('voucher.approved')->group(function () {
        // Modules & Lessons
        Route::get('/module/{id}',           [Student\ModuleController::class,     'show'])->name('module.show');
        Route::post('/lesson/{id}/complete', [Student\ModuleController::class,     'completeLesson'])->name('lesson.complete');

        // Quizzes
        Route::get('/quiz/{id}',             [Student\QuizController::class,       'show'])->name('quiz.show');
        Route::post('/quiz/{id}/submit',     [Student\QuizController::class,       'submit'])->name('quiz.submit');
        Route::get('/quiz/{id}/result',      [Student\QuizController::class,       'result'])->name('quiz.result');

        // Certificate
        Route::get('/certificate',           [Student\CertificateController::class,'index'])->name('certificate');
    });
});

// ─── TEACHER ─────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:teacher'])->prefix('teacher')->name('teacher.')->group(function () {
    Route::get('/dashboard',                      [Teacher\DashboardController::class, 'index'])->name('dashboard');

    // Modules
    Route::get('/modules',                        [Teacher\ModuleController::class, 'index'])->name('modules.index');
    Route::get('/modules/create',                 [Teacher\ModuleController::class, 'create'])->name('modules.create');
    Route::post('/modules',                       [Teacher\ModuleController::class, 'store'])->name('modules.store');
    Route::get('/modules/{id}',                   [Teacher\ModuleController::class, 'show'])->name('modules.show');
    Route::get('/modules/{id}/edit',              [Teacher\ModuleController::class, 'edit'])->name('modules.edit');
    Route::put('/modules/{id}',                   [Teacher\ModuleController::class, 'update'])->name('modules.update');
    Route::delete('/modules/{id}',                [Teacher\ModuleController::class, 'destroy'])->name('modules.destroy');
    Route::post('/modules/{id}/lesson',           [Teacher\ModuleController::class, 'addLesson'])->name('modules.addLesson');
    Route::delete('/lessons/{id}',                [Teacher\ModuleController::class, 'deleteLesson'])->name('lessons.delete');
    Route::get('/lessons/{id}/edit',              [Teacher\ModuleController::class, 'editLesson'])->name('lessons.edit');
    Route::put('/lessons/{id}',                   [Teacher\ModuleController::class, 'updateLesson'])->name('lessons.update');

    // Quizzes
    Route::get('/modules/{moduleId}/quiz/create', [Teacher\QuizController::class, 'create'])->name('quiz.create');
    Route::post('/modules/{moduleId}/quiz',        [Teacher\QuizController::class, 'store'])->name('quiz.store');
    Route::get('/quiz/{quizId}/questions',         [Teacher\QuizController::class, 'showQuestions'])->name('quiz.questions');
    Route::post('/quiz/{quizId}/questions',        [Teacher\QuizController::class, 'addQuestion'])->name('quiz.addQuestion');
    Route::delete('/questions/{id}',               [Teacher\QuizController::class, 'deleteQuestion'])->name('quiz.deleteQuestion');
});

// ─── ADMIN ───────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard',              [Admin\DashboardController::class, 'index'])->name('dashboard');

    // Teachers
    Route::get('/teachers',              [Admin\TeacherController::class, 'index'])->name('teachers.index');
    Route::get('/teachers/create',       [Admin\TeacherController::class, 'create'])->name('teachers.create');
    Route::post('/teachers',             [Admin\TeacherController::class, 'store'])->name('teachers.store');
    Route::patch('/teachers/{id}/toggle',[Admin\TeacherController::class, 'toggle'])->name('teachers.toggle');
    Route::delete('/teachers/{id}',      [Admin\TeacherController::class, 'destroy'])->name('teachers.destroy');

    // Vouchers
    Route::get('/vouchers',              [Admin\VoucherController::class, 'index'])->name('vouchers.index');
    Route::post('/vouchers/generate',    [Admin\VoucherController::class, 'generate'])->name('vouchers.generate');
    Route::patch('/vouchers/{id}/approve',[Admin\VoucherController::class,'approve'])->name('vouchers.approve');
    Route::delete('/vouchers/{id}',      [Admin\VoucherController::class, 'destroy'])->name('vouchers.destroy');

    // Students
    Route::get('/students',              [Admin\StudentController::class, 'index'])->name('students.index');
    Route::get('/students/{id}/edit',    [Admin\StudentController::class, 'edit'])->name('students.edit');
    Route::put('/students/{id}',         [Admin\StudentController::class, 'update'])->name('students.update');
});