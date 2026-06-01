<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $fillable = [
        'code',
        'generated_by',
        'assigned_to',
        'is_used',
        'is_paid',
        'is_approved',
        'approved_at',
        'used_at',
        'payment_proof',
        'notes',
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'used_at'     => 'datetime',
        'is_used'     => 'boolean',
        'is_paid'     => 'boolean',
        'is_approved' => 'boolean',
    ];

    public function generator()
    {
        return $this->belongsTo(User::class, 'generated_by');
    }

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}