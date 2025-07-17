<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Http\Request;
use App\Mail\InvoiceGeneratedMail;
use Illuminate\Support\Facades\Mail;

class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::with('items')->latest()->get();
        return view('invoices.index', compact('invoices'));
    }

    public function create()
    {
        return view('invoices.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => 'required',
            'customer_email' => 'required|email',
            'customer_address' => 'required',
            'product_name.*' => 'required',
            'quantity.*' => 'required|integer',
            'price.*' => 'required|numeric',
            'tax.*' => 'required|numeric',
        ]);

        $subtotal = 0;
        $total = 0;
        $totalTax = 0; 

        foreach ($request->product_name as $key => $product) {
            $qty = $request->quantity[$key];
            $price = $request->price[$key];
            $taxPercent = $request->tax[$key];

            $productTotal = $price * $qty;
            $taxAmount = ($productTotal * $taxPercent) / 100;
            $lineTotal = $productTotal + $taxAmount;

            $subtotal += $productTotal;
            $totalTax += $taxAmount; 
            $total += $lineTotal;
        }



        
        $invoice = Invoice::create([
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_address' => $request->customer_address,
            'subtotal' => $subtotal,
            'total' => $total,
        ]);

        
        foreach ($request->product_name as $key => $product) {
            InvoiceItem::create([
                'invoice_id' => $invoice->id,
                'product_name' => $product,
                'quantity' => $request->quantity[$key],
                'price' => $request->price[$key],
                'tax' => $request->tax[$key],
                'total' => ($request->price[$key] * $request->quantity[$key]) + 
                        (($request->price[$key] * $request->quantity[$key]) * $request->tax[$key] / 100),
            ]);
        }

        
        // Mail::to($invoice->customer_email)->send(new InvoiceGeneratedMail($invoice, $totalTax));
        Mail::to('sasikrslink18@gmail.com')->send(new InvoiceGeneratedMail($invoice, $totalTax));
        return redirect()->route('invoices.index')->with('success', 'Invoice created successfully.');
    }

    public function show($id)
    {
        $invoice = Invoice::with('items')->findOrFail($id);
        return view('invoices.show', compact('invoice'));
    }


    public function edit($id)
    {
        $invoice = Invoice::with('items')->findOrFail($id);
        return view('invoices.edit', compact('invoice'));
    }

    public function update(Request $request, Invoice $invoice)
    {
        $request->validate([
            'customer_name' => 'required',
            'customer_email' => 'required|email',
            'customer_address' => 'required',
            'product_name.*' => 'required',
            'quantity.*' => 'required|integer',
            'price.*' => 'required|numeric',
            'tax.*' => 'required|numeric',
        ]);

        $subtotal = 0;
        $total = 0;

        foreach ($request->product_name as $key => $product) {
            $qty = $request->quantity[$key];
            $price = $request->price[$key];
            $tax = $request->tax[$key];
            $lineTotal = ($price * $qty);
            $taxAmount = ($lineTotal * $tax) / 100;
            $subtotal += $lineTotal;
            $total += $lineTotal + $taxAmount;
        }

        
        $invoice->update([
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_address' => $request->customer_address,
            'subtotal' => $subtotal,
            'total' => $total,
        ]);

        
        $invoice->items()->delete();

        
        foreach ($request->product_name as $key => $product) {
            $qty = $request->quantity[$key];
            $price = $request->price[$key];
            $tax = $request->tax[$key];
            $lineTotal = $price * $qty;
            $taxAmount = ($lineTotal * $tax) / 100;

            $invoice->items()->create([
                'product_name' => $product,
                'quantity' => $qty,
                'price' => $price,
                'tax' => $tax,
                'total' => $lineTotal + $taxAmount,
            ]);
        }

        return redirect()->route('invoices.index')->with('success', 'Invoice updated successfully.');
    }


    public function destroy($id)
    {
        $invoice = Invoice::findOrFail($id);

        try {
            $invoice->items()->delete(); 
            $invoice->delete();

            return redirect()->route('invoices.index')->with('success', 'Invoice deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('invoices.index')->with('error', 'Failed to delete invoice.');
        }
    }

}

