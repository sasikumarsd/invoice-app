@extends('layouts.app')
@section('title','Show Invoice')
@section('content')
<div class="container">
    <h2>Invoice #{{ $invoice->id }}</h2>
    <p><strong>Name:</strong> {{ $invoice->customer_name }}</p>
    <p><strong>Email:</strong> {{ $invoice->customer_email }}</p>
    <p><strong>Address:</strong> {{ $invoice->customer_address }}</p>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Tax(%)</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @php $totalTax = 0; @endphp
            @foreach ($invoice->items as $item)
                @php
                    $productTotal = $item->quantity * $item->price;
                    $taxAmount = ($productTotal * $item->tax) / 100;
                    $totalTax += $taxAmount;
                @endphp
                <tr>
                    <td>{{ $item->product_name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price, 2) }}</td>
                    <td>{{ $item->tax }}</td>
                    <td>{{ number_format($item->total, 2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <p><strong>Subtotal:</strong> {{ number_format($invoice->subtotal, 2) }}</p>
    <p><strong>Total Tax:</strong> {{ number_format($totalTax, 2) }}</p>
    <p><strong>Total:</strong> {{ number_format($invoice->total, 2) }}</p>
</div>
@endsection
