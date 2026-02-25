<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    use HasFactory;

    protected $fillable = [ 'user_id','colocation_id',
                             'is_owner',
                            'joined_at','left_at'];


    protected $casts = ['is_owner' => 'boolean',
                        'joined_at' => 'datetime',
                        'left_at' => 'datetime',];

    // relations
    public function user(){
        return $this->belongsTo(User::class);
    }

    public function colocation(){
        return $this->belongsTo(Colocation::class);
    }

    public function paidExpenses()
    {
        return $this->hasMany(Expense::class, 'payer_member_id');
    }

    
    public function sentPayments()
    {
        return $this->hasMany(Payment::class, 'sender_id');
    }


    public function receivedPayments()
    {
        return $this->hasMany(Payment::class, 'receiver_id');
    }

}
