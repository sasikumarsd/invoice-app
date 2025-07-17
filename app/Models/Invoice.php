<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_name', 'customer_email', 'customer_address', 'subtotal', 'total'
    ];

    public function items()
    {
        return $this->hasMany(InvoiceItem::class);
    }
}

