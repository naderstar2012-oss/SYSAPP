<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treasury extends Model
{
    use HasFactory;

    protected $table = 'treasury';

    protected $fillable = [
        'transactionType', 'amount', 'transactionDate', 'category', 'referenceType', 'referenceId', 'description', 'notes', 'createdBy'
    ];

    protected $casts = [
        'transactionDate' => 'datetime',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'createdBy');
    }
}
