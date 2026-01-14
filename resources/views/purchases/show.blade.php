@extends('layouts.app')

@section('content')
    <div style="max-width: 1200px; margin: 0 auto; padding: 2rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h1>Purchase #{{ $purchase->id }}</h1>
            <a href="{{ url()->previous() }}" style="padding: 0.5rem 1rem; background-color: #f3f4f6; border-radius: 4px; text-decoration: none; color: #374151;">Back</a>
        </div>

        <div style="background: white; border-radius: 8px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); padding: 2rem; margin-bottom: 2rem;">
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 2rem; margin-bottom: 2rem; padding-bottom: 2rem; border-bottom: 1px solid #e5e7eb;">
                <div>
                    <h3 style="color: #6b7280; font-size: 0.875rem; font-weight: 500; text-transform: uppercase;">Status</h3>
                    <div style="font-size: 1.125rem; font-weight: 600; text-transform: capitalize;">{{ $purchase->status }}</div>
                </div>
                <div>
                    <h3 style="color: #6b7280; font-size: 0.875rem; font-weight: 500; text-transform: uppercase;">Date</h3>
                    <div style="font-size: 1.125rem; font-weight: 600;">{{ $purchase->created_at->format('M d, Y H:i') }}</div>
                </div>
                <div>
                    <h3 style="color: #6b7280; font-size: 0.875rem; font-weight: 500; text-transform: uppercase;">Total Amount</h3>
                    <div style="font-size: 1.5rem; font-weight: 700; color: #059669;">€{{ number_format($purchase->total_amount, 2) }}</div>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 2rem; margin-bottom: 2rem;">
                <!-- Client Info -->
                <div>
                    <h3 style="margin-bottom: 1rem; font-size: 1.25rem;">Customer Details</h3>
                    <div style="background: #f9fafb; padding: 1.5rem; border-radius: 6px;">
                        <div style="font-weight: 600; margin-bottom: 0.5rem;">{{ $purchase->cart->client->name }}</div>
                        <div style="color: #6b7280;">{{ $purchase->cart->client->email }}</div>
                    </div>
                </div>

                <!-- Addresses -->
                <div>
                     <h3 style="margin-bottom: 1rem; font-size: 1.25rem;">Addresses</h3>
                     <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div style="background: #f9fafb; padding: 1rem; border-radius: 6px;">
                            <h4 style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.5rem;">Delivery Address</h4>
                            @if($purchase->deliveryAddress)
                                <div>{{ $purchase->deliveryAddress->address_line1 }}</div>
                                @if($purchase->deliveryAddress->address_line2)
                                    <div>{{ $purchase->deliveryAddress->address_line2 }}</div>
                                @endif
                                <div>{{ $purchase->deliveryAddress->city }}, {{ $purchase->deliveryAddress->postal_code }}</div>
                                <div>{{ $purchase->deliveryAddress->country }}</div>
                            @else
                                <div style="color: #9ca3af; font-style: italic;">No delivery address provided</div>
                            @endif
                        </div>
                        <div style="background: #f9fafb; padding: 1rem; border-radius: 6px;">
                            <h4 style="font-size: 0.875rem; color: #6b7280; margin-bottom: 0.5rem;">Payment Address</h4>
                            @if($purchase->paymentAddress)
                                <div>{{ $purchase->paymentAddress->address_line1 }}</div>
                                @if($purchase->paymentAddress->address_line2)
                                    <div>{{ $purchase->paymentAddress->address_line2 }}</div>
                                @endif
                                <div>{{ $purchase->paymentAddress->city }}, {{ $purchase->paymentAddress->postal_code }}</div>
                                <div>{{ $purchase->paymentAddress->country }}</div>
                            @else
                                <div style="color: #9ca3af; font-style: italic;">Same as delivery</div>
                            @endif
                        </div>
                     </div>
                </div>
            </div>

            <!-- Order Items -->
            <div>
                <h3 style="margin-bottom: 1rem; font-size: 1.25rem;">Order Items</h3>
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="border-bottom: 2px solid #e5e7eb;">
                            <th style="padding: 0.75rem; color: #6b7280;">Image</th>
                            <th style="padding: 0.75rem; color: #6b7280;">Product</th>
                            <th style="padding: 0.75rem; color: #6b7280;">Price</th>
                            <th style="padding: 0.75rem; color: #6b7280;">Quantity</th>
                            <th style="padding: 0.75rem; color: #6b7280; text-align: right;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($purchase->cart->products as $product)
                            <tr style="border-bottom: 1px solid #f3f4f6;">
                                <td style="padding: 0.75rem;">
                                    @if($product->image)
                                        <img src="{{ $product->image }}" alt="{{ $product->name['en'] ?? 'Product' }}" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                    @else
                                        <div style="width: 50px; height: 50px; background-color: #e5e7eb; border-radius: 4px; display: flex; align-items: center; justify-content: center; color: #9ca3af; font-size: 0.75rem;">No Img</div>
                                    @endif
                                </td>
                                <td style="padding: 0.75rem; font-weight: 500;"><a href="{{ route('products.show', $product) }}" style="color: #2563eb; text-decoration: none;">{{ $product->name['en'] ?? $product->name[array_key_first($product->name)] }}</a></td>
                                <td style="padding: 0.75rem;">€{{ number_format($product->pivot->price, 2) }}</td>
                                <td style="padding: 0.75rem;">{{ $product->pivot->quantity }}</td>
                                <td style="padding: 0.75rem; text-align: right; font-weight: 600;">
                                    €{{ number_format($product->pivot->price * $product->pivot->quantity, 2) }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="3" style="padding: 1rem; text-align: right; font-weight: 600;">Total</td>
                            <td style="padding: 1rem; text-align: right; font-weight: 700; font-size: 1.125rem;">
                                €{{ number_format($purchase->total_amount, 2) }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
@endsection
