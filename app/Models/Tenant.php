<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use \Illuminate\Database\Eloquent\Factories\HasFactory;

    protected $fillable = [
        'name',
        'subdomain',
        'domain',
        'tenant_logo',
        'meta_description',
    ];

    protected $casts = [
        'meta_description' => 'array',
    ];
}
