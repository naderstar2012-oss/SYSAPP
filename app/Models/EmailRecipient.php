<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailRecipient extends Model
{
    use HasFactory;

    protected $fillable = [
        'email', 'name', 'isActive', 'createdBy'
    ];

    protected $casts = [
        'isActive' => 'boolean',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'createdBy');
    }
}
