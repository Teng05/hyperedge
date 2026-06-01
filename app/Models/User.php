<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'first_name', 'last_name', 'email', 'password',
        'role', 'birthday', 'contact_number',
        'affiliation_type', 'affiliation_name',
        'is_active', 'email_verified',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'birthday'          => 'date',
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
        'is_active'         => 'boolean',
        'email_verified'    => 'boolean',
    ];

    // ── Attribute helpers ─────────────────────────────────────
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /** Returns "JD" for Juan dela Cruz — used for avatar initials in sidebar */
    public function getInitialsAttribute(): string
    {
        return strtoupper(
            substr($this->first_name, 0, 1) . substr($this->last_name, 0, 1)
        );
    }

    // ── Role helpers ──────────────────────────────────────────
    public function isAdmin(): bool   { return $this->role === 'admin'; }
    public function isTeacher(): bool { return $this->role === 'teacher'; }
    public function isStudent(): bool { return $this->role === 'student'; }

    // ── Relationships ─────────────────────────────────────────
    public function moduleProgress()
    {
        return $this->hasMany(StudentModuleProgress::class);
    }

    public function lessonProgress()
    {
        return $this->hasMany(StudentLessonProgress::class);
    }

    public function quizAttempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    public function certificate()
    {
        return $this->hasOne(Certificate::class);
    }

    /**
     * Uses 'assigned_to' as the foreign key on the vouchers table.
     */
    public function voucher()
    {
        return $this->hasOne(Voucher::class, 'assigned_to');
    }
}