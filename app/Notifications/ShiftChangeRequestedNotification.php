<?php

namespace App\Notifications;

use App\Models\Duty;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class ShiftChangeRequestedNotification extends Notification
{
    use Queueable;

    public $duty;

    // Constructor to pass the duty that the shift change was requested for
    public function __construct(Duty $duty)
    {
        $this->duty = $duty;
    }

    // Define the notification channels (Database, Mail, etc.)
    public function via($notifiable)
    {
        return ['database']; // Use database notifications for this example
    }

    // The data to store in the database notification
    public function toDatabase($notifiable)
    {
        return [
            'duty_id' => $this->duty->id,
            'title' => $this->duty->title,
            'description' => $this->duty->description,
            'time' => $this->duty->time,
            'shift_change_requested' => true,
        ];
    }
}
