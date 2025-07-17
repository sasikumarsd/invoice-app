<h2>Invoice #{{ $invoice->id }}</h2>

<p><strong>Name:</strong> {{ $invoice->customer_name }}</p>
<p><strong>Email:</strong> {{ $invoice->customer_email }}</p>
<p><strong>Address:</strong> {{ $invoice->customer_address }}</p>

<table width="100%" border="1" cellspacing="0" cellpadding="8">
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
        @foreach ($invoice->items as $item)
        <tr>
            <td>{{ $item->product_name }}</td>
            <td>{{ $item->quantity }}</td>
            <td>{{ $item->price }}</td>
            <td>{{ $item->tax }}</td>
            <td>{{ $item->total }}</td>
        </tr>
        @endforeach
    </tbody>
</table>

<p><strong>Subtotal:</strong> {{ $invoice->subtotal }}</p>
<p><strong>Tax Amount:</strong> {{ number_format($totalTax, 2) }}</p>
<p><strong>Total:</strong> {{ number_format($invoice->total, 2) }}</p>
