<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'nameAr', 'nameEn', 'code', 'currency', 'currencySymbol'
    ];

    public $timestamps = false; // لا يوجد updatedAt في الجدول الأصلي

    public function properties()
    {
        return $this->hasMany(Property::class, 'countryId');
    }
}
