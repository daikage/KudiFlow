<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = ['tenant_id','customer_id','subtotal','tax','total','payment_method','status'];

    public function items() { return $this->hasMany(SaleItem::class); }
}
