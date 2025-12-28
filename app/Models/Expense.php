<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = [
        'propertyId', 'description', 'amount', 'expenseDate', 'category', 'receiptFileUrl', 'receiptFileKey', 'notes', 'createdBy'
    ];

    protected $casts = [
        'expenseDate' => 'datetime',
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
