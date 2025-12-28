<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'contractId', 'invoiceNumber', 'amount', 'dueDate', 'status', 'paidDate', 'notes', 'createdBy'
    ];

    protected $casts = [
        'dueDate' => 'datetime',
        'paidDate' => 'datetime',
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contractId');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'createdBy');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'invoiceId');
    }
}
