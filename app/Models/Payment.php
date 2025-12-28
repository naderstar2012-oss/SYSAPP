<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoiceId', 'amount', 'paymentDate', 'paymentMethod', 'receiptFileUrl', 'receiptFileKey', 'disbursementFileUrl', 'disbursementFileKey', 'notes', 'createdBy'
    ];

    protected $casts = [
        'paymentDate' => 'datetime',
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoiceId');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'createdBy');
    }
}
