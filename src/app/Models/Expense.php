<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{

    use HasFactory;


    protected $fillable = ['title','amount','date','payer_member_id',
                            'colocation_id','category_id'];

    protected $casts = [];

    public function payer()
    {
        return $this->belongsTo(User::class, 'payer_member_id');
    }

    public function colocation()
    {
        return $this->belongsTo(Colocation::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
