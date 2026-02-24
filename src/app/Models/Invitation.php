<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\InvitationStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = ['email','token','colocation_id','status'];

    protected $casts = ['status' => InvitationStatus::class,];

    public function colocation(){
        return $this->belongsTo(Colocation::class);
    }
}
