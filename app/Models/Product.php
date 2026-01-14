<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'name',
        'category_name',
        'price',
        'currency',
        'description',
        'benefits',
    ];

    protected $casts = [
        'name' => 'array',
        'category_name' => 'array',
        'description' => 'array',
        'benefits' => 'array',
        'price' => 'decimal:2',
    ];
}
