@extends('layouts.app')
@section('title','Create Invoice')
@section('content')
<div class="container">
    <h2>Create Invoice</h2>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('invoices.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="customer_name" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="customer_email" class="form-control" required>
        </div>
        <div class="mb-3">
            <label>Address</label>
            <textarea name="customer_address" class="form-control" required></textarea>
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
                <tr>
                    <td><input type="text" name="product_name[]" class="form-control" required></td>
                    <td><input type="number" name="quantity[]" class="form-control qty" required></td>
                    <td><input type="number" step="0.01" name="price[]" class="form-control price" required></td>
                    <td><input type="number" step="0.01" name="tax[]" class="form-control tax" required></td>
                    <td><input type="number" step="0.01" class="form-control total" readonly></td>
                    <td><button type="button" class="btn btn-sm btn-danger remove_row">−</button></td>
                </tr>
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

