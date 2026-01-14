@extends('layouts.app')

@section('content')
    <div style="max-width: 800px; margin: 0 auto; padding: 2rem;">
        <h1 style="font-size: 2rem; margin-bottom: 1rem;">{{ $product->name['en'] ?? $product->name[array_key_first($product->name)] }}</h1>
        @if($product->image)
            <img src="{{ $product->image }}" alt="{{ $product->name['en'] ?? 'Product' }}" style="width: 100%; max-width: 400px; height: auto; object-fit: cover; border-radius: 8px; margin-bottom: 1rem;">
        @endif
        <p style="font-size: 1.125rem; color: #4b5563; margin-bottom: 1rem;">
            <strong>Price:</strong> €{{ number_format($product->price, 2) }} {{ $product->currency }}
        </p>
        <h3 style="font-size: 1.25rem; margin-top: 1.5rem; margin-bottom: 0.5rem;">Description</h3>
        <p style="color: #4b5563;">{{ $product->description['en'] ?? $product->description[array_key_first($product->description)] }}</p>
        <h3 style="font-size: 1.25rem; margin-top: 1.5rem; margin-bottom: 0.5rem;">Category</h3>
        <p style="color: #4b5563;">{{ $product->category_name['en'] ?? $product->category_name[array_key_first($product->category_name)] }}</p>
        @if(!empty($product->benefits))
            <h3 style="font-size: 1.25rem; margin-top: 1.5rem; margin-bottom: 0.5rem;">Benefits</h3>
            <ul style="color: #4b5563; list-style: disc inside;">
                @foreach($product->benefits as $benefit)
                    <li>{{ $benefit['en'] ?? $benefit[array_key_first($benefit)] }}</li>
                @endforeach
            </ul>
        @endif
        <a href="{{ url()->previous() }}" style="display: inline-block; margin-top: 2rem; padding: 0.5rem 1rem; background-color: #f3f4f6; border-radius: 4px; text-decoration: none; color: #374151;">Back</a>
    </div>
@endsection
