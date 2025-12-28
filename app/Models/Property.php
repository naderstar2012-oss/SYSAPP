<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'type', 'countryId', 'city', 'address', 'description', 'area', 'rooms', 'bathrooms', 'floor', 'status', 'notes', 'createdBy'
    ];

    public function country()
    {
        return $this->belongsTo(Country::class, 'countryId');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'createdBy');
    }
}
