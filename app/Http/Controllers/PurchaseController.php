<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function show(Purchase $purchase)
    {
        // Eager load everything needed for the view
        $purchase->load([
            'cart.client',
            'cart.products',
            'deliveryAddress',
            'paymentAddress'
        ]);

        return view('purchases.show', compact('purchase'));
    }
}
