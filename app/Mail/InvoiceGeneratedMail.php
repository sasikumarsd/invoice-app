<?php

namespace App\Mail;

use App\Models\Invoice;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceGeneratedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $invoice;

    public $totalTax;

    public function __construct(Invoice $invoice, $totalTax)
    {
        $this->invoice = $invoice->load('items');

        $this->totalTax = $totalTax;
    }

    public function build()
    {
        return $this->subject('Your Invoice from Invoice App')
            ->view('emails.invoice')
            ->with([
                'totalTax' => $this->totalTax,
            ]);
    }
}

