<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class StudentModuleProgress extends Model
{
    protected $fillable = ['user_id','module_id','is_unlocked','is_completed','completed_at'];
    protected $casts = ['completed_at' => 'datetime'];
    public function user()   { return $this->belongsTo(User::class); }
    public function module() { return $this->belongsTo(Module::class); }
}
