<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'propertyId', 'tenantId', 'contractType', 'contractNumber', 'contractFileUrl', 'contractFileKey', 'startDate', 'endDate', 'rentAmount', 'salePrice', 'paymentType', 'rentSystem', 'deposit', 'status', 'notes', 'createdBy'
    ];

    protected $casts = [
        'startDate' => 'datetime',
        'endDate' => 'datetime',
    ];

    public function property()
    {
        return $this->belongsTo(Property::class, 'propertyId');
    }

    public function tenant()
    {
        return $this->belongsTo(Tenant::class, 'tenantId');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'createdBy');
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'contractId');
    }
}
