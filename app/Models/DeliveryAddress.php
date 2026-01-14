<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'address_line1',
        'address_line2',
        'city',
        'postal_code',
        'country',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
