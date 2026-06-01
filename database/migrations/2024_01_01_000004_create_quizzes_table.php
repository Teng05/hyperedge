<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Per-module 5-point assessments + final long quiz
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('module_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('title');
            $table->enum('type', ['module_assessment', 'final_exam'])->default('module_assessment');
            $table->integer('passing_score')->default(3); // 3/5 for module, 25/30 for final
            $table->integer('total_points')->default(5);
            $table->boolean('randomize')->default(false);
            $table->boolean('show_answers')->default(false); // always false per requirement
            $table->timestamps();
        });

        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')->constrained()->onDelete('cascade');
            $table->text('question_text');
            $table->string('choice_a');
            $table->string('choice_b');
            $table->string('choice_c');
            $table->string('choice_d');
            $table->enum('correct_answer', ['a', 'b', 'c', 'd']);
            $table->integer('points')->default(1);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('questions');
        Schema::dropIfExists('quizzes');
    }
};
