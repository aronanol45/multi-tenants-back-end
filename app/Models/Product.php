<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'category_name',
        'price',
        'currency',
        'description',
        'benefits',
        'image',
    ];

    protected $casts = [
        'name' => 'array',
        'category_name' => 'array',
        'description' => 'array',
        'benefits' => 'array',
    ];
}
