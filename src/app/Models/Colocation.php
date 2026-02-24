<?php

namespace App\Models;

use App\Enums\ColocationStatus;
use Illuminate\Database\Eloquent\Model;

class Colocation extends Model
{
    protected $fillable = ['name','status'];

    protected $casts = ['status' => ColocationStatus::class,];

    // relationss
    public function memberships(){
        return $this->hasMany(Membership::class);
    }

    public function expenses(){
        return $this->hasMany(Expense::class);
    }
}
