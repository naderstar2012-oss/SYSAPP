<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tenant extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'nationality', 'idNumber', 'phone', 'email', 'alternativePhone', 'address', 'notes', 'createdBy'
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'createdBy');
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class, 'tenantId');
    }
}
