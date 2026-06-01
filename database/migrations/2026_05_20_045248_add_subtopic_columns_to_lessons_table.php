<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->text('video_explanation')->nullable()->after('video_url');
            $table->text('ppt_slides')->nullable()->after('video_explanation'); // JSON array of 5-6 slides
            $table->string('video_thumbnail')->nullable()->after('ppt_slides'); // layout capture area
            $table->text('code_snippet')->nullable()->after('video_thumbnail');
            $table->string('code_explanation_video')->nullable()->after('code_snippet');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            $table->dropColumn([
                'video_explanation',
                'ppt_slides',
                'video_thumbnail',
                'code_snippet',
                'code_explanation_video'
            ]);
        });
    }
};
