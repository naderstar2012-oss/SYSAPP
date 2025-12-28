<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'propertyId', 'title', 'description', 'type', 'priority', 'status', 'cost', 'scheduledDate', 'completedDate', 'contractor', 'notes', 'createdBy'
    ];

    protected $casts = [
        'scheduledDate' => 'datetime',
        'completedDate' => 'datetime',
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
