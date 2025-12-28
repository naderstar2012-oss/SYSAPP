<?php

namespace App\Services;

use App\Mail\NotificationMail;
use App\Models\NotificationLog;
use Illuminate\Support\Facades\Mail;

class NotificationService
{
    /**
     * Send an email notification and log the attempt.
     */
    public function sendEmail(string $recipient, string $subject, string $body): bool
    {
        $status = 'pending';
        $errorMessage = null;

        try {
            Mail::to($recipient)->send(new NotificationMail($subject, $body));
            $status = 'sent';
            $success = true;
        } catch (\Exception $e) {
            $status = 'failed';
            $errorMessage = $e->getMessage();
            $success = false;
        }

        NotificationLog::create([
            'type' => 'email',
            'recipient' => $recipient,
            'subject' => $subject,
            'body' => $body,
            'status' => $status,
            'error_message' => $errorMessage,
        ]);

        return $success;
    }

    /**
     * Send an SMS notification and log the attempt.
     * NOTE: This is a placeholder. Real SMS integration (e.g., Twilio, Nexmo) would be implemented here.
     */
    public function sendSms(string $recipient, string $message): bool
    {
        $status = 'pending';
        $errorMessage = null;
        $success = false;

        try {
            // Placeholder for real SMS sending logic
            // Example: $client->messages->create($recipient, ['from' => $from, 'body' => $message]);

            // Simulate success for now
            $status = 'sent';
            $success = true;
        } catch (\Exception $e) {
            $status = 'failed';
            $errorMessage = $e->getMessage();
            $success = false;
        }

        NotificationLog::create([
            'type' => 'sms',
            'recipient' => $recipient,
            'subject' => 'SMS Notification',
            'body' => $message,
            'status' => $status,
            'error_message' => $errorMessage,
        ]);

        return $success;
    }
}
