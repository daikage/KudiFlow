<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = ['tenant_id','title','amount','date','notes'];

    // Cast the 'date' attribute to a Carbon instance so ->format() works in views
    protected $casts = [
        'date' => 'date',
    ];
}
