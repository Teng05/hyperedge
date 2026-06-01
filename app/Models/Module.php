<?php
// Module.php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = ['teacher_id','title','description','order','is_active','is_locked'];

    public function teacher()    { return $this->belongsTo(User::class, 'teacher_id'); }
    public function lessons()    { return $this->hasMany(Lesson::class)->orderBy('order'); }
    public function quiz()       { return $this->hasOne(Quiz::class); }
    public function progress()   { return $this->hasMany(StudentModuleProgress::class); }
}
