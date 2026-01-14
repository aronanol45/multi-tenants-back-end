<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    //
    public function show(\App\Models\Cart $cart)
    {
        $cart->load(['client', 'products']);
        return view('carts.show', compact('cart'));
    }
}
