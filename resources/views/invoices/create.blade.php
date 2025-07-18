@extends('layouts.app')
@section('title','Create Invoice')
@section('content')
<div class="container">
    <h2>Create Invoice</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('invoices.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="customer_name" class="form-control" required value="{{ old('customer_name') }}">
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="customer_email" class="form-control" required value="{{ old('customer_email') }}">
        </div>
        <div class="mb-3">
            <label>Address</label>
            <textarea name="customer_address" class="form-control" required>{{ old('customer_address') }}</textarea>
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
                @php
                    $products = old('product_name', []) ?: [''];
                    $quantities = old('quantity', []);
                    $prices = old('price', []);
                    $taxes = old('tax', []);
                @endphp

                @foreach ($products as $i => $product)
                    <tr>
                        <td><input type="text" name="product_name[]" class="form-control" value="{{ $product }}" required></td>
                        <td><input type="number" name="quantity[]" class="form-control qty" value="{{ $quantities[$i] ?? '' }}" required></td>
                        <td><input type="number" step="0.01" name="price[]" class="form-control price" value="{{ $prices[$i] ?? '' }}" required></td>
                        <td><input type="number" step="0.01" name="tax[]" class="form-control tax" value="{{ $taxes[$i] ?? '' }}" required></td>
                        <td><input type="number" step="0.01" class="form-control total" readonly></td>
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
                            <td><input type="text" id="subtotal" class="form-control" readonly></td>
                        </tr>
                        <tr>
                            <th>Total Tax:</th>
                            <td><input type="text" id="tax_total" class="form-control" readonly></td>
                        </tr>
                        <tr>
                            <th>Grand Total:</th>
                            <td><input type="text" id="grand_total" class="form-control fw-bold text-success" readonly></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>


        <button type="submit" class="btn btn-primary">Save Invoice</button>
    </form>
</div>
@endsection

@section('scripts')
    @include('invoices.scripts.calculation')
@endsection

