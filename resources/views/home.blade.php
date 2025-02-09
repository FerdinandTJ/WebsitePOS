@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="mt-4">
                        @if(auth()->check() && auth()->user()->role === 'owner')
                            <a href="{{ route('products.index') }}" class="btn btn-primary">Manage Products</a>
                            <a href="{{ route('sales.report') }}" class="btn btn-success">Sales Report</a>
                        @elseif(auth()->check() && auth()->user()->role === 'cashier')
                            <a href="{{ route('orders.index') }}" class="btn btn-primary">Manage Orders</a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection