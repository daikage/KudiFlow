<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TenantRolePermission extends Model
{
    protected $fillable = ['tenant_id', 'role', 'permissions'];

    protected $casts = [
        'permissions' => 'array',
    ];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }
}
