<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
        'date',
        'is_confirmed',
        'sender_id',
        'receiver_id'
    ];

    protected $casts = [
        'is_confirmed' => 'boolean',
        'date' => 'datetime',
    ];

    // sender
    public function sender()
    {
        return $this->belongsTo(Membership::class, 'sender_id');
    }

    // receiver
    public function receiver()
    {
        return $this->belongsTo(Membership::class, 'receiver_id');
    }
}
