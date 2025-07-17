<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\InvoiceController;

use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceGeneratedMail;
use App\Models\Invoice;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/',[InvoiceController::class, 'index']);



// Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
// Route::get('/invoices/create', [InvoiceController::class, 'create'])->name('invoices.create');
// Route::post('/invoices', [InvoiceController::class, 'store'])->name('invoices.store');
// Route::get('/invoices/{invoice}', [InvoiceController::class, 'show'])->name('invoices.show');
// Route::delete('/invoices/{id}', [InvoiceController::class, 'delete'])->name('invoices.delete');
// Route::get('/invoices/{invoice}/edit', [InvoiceController::class, 'edit'])->name('invoices.edit');
// Route::put('/invoices/{invoice}', [InvoiceController::class, 'update'])->name('invoices.update');


Route::resource('invoices', InvoiceController::class);



Route::get('/test-mail', function () {
    $invoice = Invoice::with('items')->latest()->first();

    $totalTax = 0;
    foreach ($invoice->items as $item) {
        $productTotal = $item->price * $item->quantity;
        $taxAmount = ($productTotal * $item->tax) / 100;
        $totalTax += $taxAmount;
    }

    Mail::to('sasikrslink18@gmail.com')->send(new InvoiceGeneratedMail($invoice, $totalTax));

    return 'Mail sent!';
});