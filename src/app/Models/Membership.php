<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    protected $fillable = [ 'user_id','colocation_id',
                             'reputation_score','is_owner',
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

}
