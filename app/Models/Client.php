<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /** @use HasFactory<\Database\Factories\ClientFactory> */
    use HasFactory;

    protected $fillable = ['tenant_id', 'name', 'email'];

    public function tenant()
    {
        return $this->belongsTo(Tenant::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }
}
