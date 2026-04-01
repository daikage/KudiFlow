<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'tenant_id','category_id','name','sku','price','cost','stock','min_stock','status','image_url'
    ];

    public function tenant() { return $this->belongsTo(Tenant::class); }
    public function category() { return $this->belongsTo(Category::class); }
}
