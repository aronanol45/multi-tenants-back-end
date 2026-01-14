<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->paginate(100);
        return view('products.index', compact('products'));
    }

    public function show(Product $product)
    {
        // Eager load any relationships if needed (e.g., categories)
        return view('products.show', compact('product'));
    }
}
