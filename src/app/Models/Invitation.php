<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\InvitationStatus;

class Invitation extends Model
{
    protected $fillable = ['email','token','colocation_id','status'];

    protected $casts = ['status' => InvitationStatus::class,];

    public function colocation(){
        return $this->belongsTo(Colocation::class);
    }
}
