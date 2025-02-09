@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Sales Report</h1>
    <div class="mb-3">
        <strong>Total Sales:</strong> Rp {{ number_format($totalSales, 2) }}
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Order ID</th>
                <th>Customer Name</th>
                <th>Cashier Name</th>
                <th>Total Price</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->customer_name }}</td>
                <td>{{ $order->cashier_name }}</td>
                <td>Rp {{ number_format($order->total_price, 2) }}</td>
                <td>
                    <ul>
                        @foreach($order->items as $item)
                        <li>
                            {{ $item->product->name }} (Qty: {{ $item->quantity }}, Price: Rp {{ number_format($item->price, 2) }})
                        </li>
                        @endforeach
                    </ul>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection