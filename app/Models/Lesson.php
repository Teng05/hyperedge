<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = [
        'module_id', 'title', 'type', 'file_path', 'video_url', 'order',
        'video_explanation', 'ppt_slides', 'video_thumbnail', 'code_snippet', 'code_explanation_video'
    ];

    protected $casts = [
        'ppt_slides' => 'array',
    ];

    protected $appends = ['pdf_path'];

    public function getPdfPathAttribute()
    {
        return $this->file_path;
    }

    public function module() { return $this->belongsTo(Module::class); }
}
