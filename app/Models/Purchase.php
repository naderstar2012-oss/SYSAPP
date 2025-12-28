<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'propertyId', 'description', 'amount', 'purchaseDate', 'category', 'supplier', 'invoiceNumber', 'receiptFileUrl', 'receiptFileKey', 'notes', 'createdBy'
    ];

    protected $casts = [
        'purchaseDate' => 'datetime',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class, 'propertyId');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'createdBy');
    }
}
