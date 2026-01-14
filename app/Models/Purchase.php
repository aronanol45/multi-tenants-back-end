<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    /** @use HasFactory<\Database\Factories\PurchaseFactory> */
    use HasFactory;

    protected $fillable = ['cart_id', 'total_amount', 'status'];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
}
