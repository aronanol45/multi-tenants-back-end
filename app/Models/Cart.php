<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    /** @use HasFactory<\Database\Factories\CartFactory> */
    use HasFactory;

    protected $fillable = ['client_id', 'is_active'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'cart_products')
                    ->withPivot(['price', 'quantity'])
                    ->withTimestamps();
    }

    public function purchase()
    {
        return $this->hasOne(Purchase::class);
    }
}
