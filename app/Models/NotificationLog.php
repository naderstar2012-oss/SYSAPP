<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationLog extends Model
{
    use HasFactory;

    protected $table = 'notification_log';

    protected $fillable = [
        'recipient', 'type', 'status', 'subject', 'message', 'sentAt', 'errorMessage', 'referenceType', 'referenceId', 'createdBy'
    ];

    public $timestamps = true; // نعم، يحتوي على created_at و updated_at

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'createdBy');
    }
}
