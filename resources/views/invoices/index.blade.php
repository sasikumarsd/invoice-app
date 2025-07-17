@extends('layouts.app')
@section('title','All Invoice')
@section('content')
<div class="container">
    <h2>Invoices</h2>
    <a href="{{ route('invoices.create') }}" class="btn btn-success mb-3">Create New</a>

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


    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Subtotal</th>
                <th>Total Tax</th>
                <th>Total</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoices as $invoice)
            <tr>
                <td>{{ $invoice->id }}</td>
                <td>{{ $invoice->customer_name }}</td>
                <td>{{ $invoice->customer_email }}</td>
                <td>{{ $invoice->subtotal }}</td>

                <td>
                    @php
                        $taxTotal = 0;
                        foreach ($invoice->items as $item) {
                            $productTotal = $item->price * $item->quantity;
                            $taxTotal += ($productTotal * $item->tax) / 100;
                        }
                    @endphp
                    {{ number_format($taxTotal, 2) }}
                </td>

                <td>{{ $invoice->total }}</td>
                <td>
                    <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-sm btn-info">View</a>
                    <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('invoices.destroy', $invoice->id) }}" method="POST" style="display:inline-block;" onsubmit="return confirm('Are you sure you want to delete this invoice?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                </td>

            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
