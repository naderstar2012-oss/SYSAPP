<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'userId', 'emailEnabled', 'emailContractExpiry', 'emailPaymentOverdue', 'emailPaymentReminder', 'emailMaintenance', 'smsEnabled', 'smsContractExpiry', 'smsPaymentOverdue', 'smsPaymentReminder', 'smsMaintenance', 'phoneNumber', 'createdBy'
    ];

    protected $casts = [
        'emailEnabled' => 'boolean',
        'emailContractExpiry' => 'boolean',
        'emailPaymentOverdue' => 'boolean',
        'emailPaymentReminder' => 'boolean',
        'emailMaintenance' => 'boolean',
        'smsEnabled' => 'boolean',
        'smsContractExpiry' => 'boolean',
        'smsPaymentOverdue' => 'boolean',
        'smsPaymentReminder' => 'boolean',
        'smsMaintenance' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'createdBy');
    }
}
