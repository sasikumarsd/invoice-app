@extends('layouts.app')
@section('title','Edit Invoice')
@section('content')
<div class="container">
    <h2>Edit Invoice</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('invoices.update', $invoice->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="customer_name" class="form-control" value="{{ $invoice->customer_name }}" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="customer_email" class="form-control" value="{{ $invoice->customer_email }}" required>
        </div>
        <div class="mb-3">
            <label>Address</label>
            <textarea name="customer_address" class="form-control" required>{{ $invoice->customer_address }}</textarea>
        </div>

        <h5>Products</h5>
        <table class="table table-bordered" id="product_table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Tax (%)</th>
                    <th>Total</th>
                    <th><button type="button" class="btn btn-sm btn-success" id="add_row">+</button></th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $item)
                <tr>
                    <td><input type="text" name="product_name[]" class="form-control" value="{{ $item->product_name }}" required></td>
                    <td><input type="number" name="quantity[]" class="form-control qty" value="{{ $item->quantity }}" required></td>
                    <td><input type="number" name="price[]" step="0.01" class="form-control price" value="{{ $item->price }}" required></td>
                    <td><input type="number" name="tax[]" step="0.01" class="form-control tax" value="{{ $item->tax }}" required></td>
                    <td><input type="number" class="form-control total" readonly value="{{ $item->total }}"></td>
                    <td><button type="button" class="btn btn-sm btn-danger remove_row">−</button></td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3">
            <div class="row">
                <div class="col-md-4 offset-md-8">
                    <table class="table">
                        <tr>
                            <th>Subtotal:</th>
                            <td><input type="text" id="subtotal" class="form-control" readonly value="{{ $invoice->subtotal }}"></td>
                        </tr>
                        <tr>
                            <th>Total Tax:</th>
                            <td><input type="text" id="tax_total" class="form-control" readonly value="{{ $invoice->total - $invoice->subtotal }}"></td>
                        </tr>
                        <tr>
                            <th>Grand Total:</th>
                            <td><input type="text" id="grand_total" class="form-control fw-bold text-success" readonly value="{{ $invoice->total }}"></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Update Invoice</button>
    </form>
</div>
@endsection

@section('scripts')
    @include('invoices.scripts.calculation')
@endsection

