@extends('layouts.app')

@section('content')
    <div class="header-actions">
        <h1>Products</h1>
        <a href="#" class="btn-primary">Create New Product</a>
    </div>

    <table border="0" cellpadding="0" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name (EN)</th>
                <th>Category</th>
                <th>Price</th>
                <th>Creation Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
                <tr>
                    <td>{{ $product->id }}</td>
                    <td>{{ $product->name['en'] ?? (is_array($product->name) ? reset($product->name) : $product->name) }}</td>
                    <td>{{ $product->category_name['en'] ?? (is_array($product->category_name) ? reset($product->category_name) : $product->category_name) }}</td>
                    <td>{{ number_format($product->price, 2) }} {{ $product->currency }}</td>
                    <td>{{ $product->created_at->format('d/m/Y') }}</td>
                    <td>
                        <a href="#" style="color: #2563eb; margin-right: 0.5rem; text-decoration: none; font-size: 0.875rem;">Edit</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 2rem;">
        {{ $products->links() }}
    </div>
@endsection
