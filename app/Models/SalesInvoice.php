<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesInvoice extends Model
{
    protected $fillable = [
        'customer_id', 'invoice_number', 'invoice_date', 'due_date',
        'subtotal', 'discount', 'tax', 'total', 'status', 'notes',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function salesInvoiceItems()
    {
        return $this->hasMany(SalesInvoiceItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
}
