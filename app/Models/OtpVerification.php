<?php namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class OtpVerification extends Model
{
    protected $fillable = ['email','otp_code','expires_at','is_used'];
    protected $casts = ['expires_at' => 'datetime'];

    public function isExpired(): bool
    {
        return now()->isAfter($this->expires_at);
    }
}
