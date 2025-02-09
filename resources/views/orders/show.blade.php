@extends('layouts.app')

@section('content')
<div class="order-detail-container">
    <h1>Order Details</h1>
    <div class="order-info">
        <p><strong>Order ID:</strong> {{ $order->id }}</p>
        <p><strong>Customer Name:</strong> {{ $order->customer_name }}</p>
        <p><strong>Cashier Name:</strong> {{ $order->cashier_name }}</p>
        <p><strong>Total Price:</strong> Rp {{ number_format($order->total_price, 2) }}</p>
    </div>
    <div class="order-items">
        <h2>Items</h2>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($order->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>Rp {{ number_format($item->price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <a href="{{ route('orders.index') }}" class="btn btn-back">Back to Orders</a>
</div>
@endsection