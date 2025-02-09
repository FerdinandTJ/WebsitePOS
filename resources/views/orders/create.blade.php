@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Create New Order</h1>
    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="customer_name">Customer Name</label>
            <input type="text" name="customer_name" id="customer_name" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="cashier_name">Cashier Name</label>
            <input type="text" name="cashier_name" id="cashier_name" class="form-control" value="{{ auth()->user()->name }}" readonly>
        </div>
        <div class="form-group">
            <label for="items">Items</label>
            <table class="table" id="items-table">
                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <select name="items[0][product_id]" class="form-control" required>
                                @foreach($products as $product)
                                    <option value="{{ $product->id }}">{{ $product->name }} (Stock: {{ $product->stock }})</option>
                                @endforeach
                            </select>
                        </td>
                        <td>
                            <input type="number" name="items[0][quantity]" class="form-control" min="1" required>
                        </td>
                        <td>
                            <button type="button" class="btn btn-danger remove-item">Remove</button>
                        </td>
                    </tr>
                </tbody>
            </table>
            <button type="button" class="btn btn-success" id="add-item">Add Item</button>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>

<script>
    document.getElementById('add-item').addEventListener('click', function() {
        const table = document.getElementById('items-table').getElementsByTagName('tbody')[0];
        const rowCount = table.rows.length;
        const newRow = table.insertRow(rowCount);

        const cell1 = newRow.insertCell(0);
        const cell2 = newRow.insertCell(1);
        const cell3 = newRow.insertCell(2);

        cell1.innerHTML = `
            <select name="items[${rowCount}][product_id]" class="form-control" required>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }} (Stock: {{ $product->stock }})</option>
                @endforeach
            </select>
        `;
        cell2.innerHTML = `<input type="number" name="items[${rowCount}][quantity]" class="form-control" min="1" required>`;
        cell3.innerHTML = `<button type="button" class="btn btn-danger remove-item">Remove</button>`;
    });

    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('remove-item')) {
            event.target.closest('tr').remove();
        }
    });
</script>
@endsection