<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class DutyAssignedNotification extends Notification
{
    use Queueable;

    private $duty;

    public function __construct($duty)
    {
        $this->duty = $duty;
    }

    // Send the notification via database
    public function via($notifiable)
    {
        return ['database'];
    }

    // Data stored in the database
    public function toDatabase($notifiable)
    {
        return [
            'title' => 'New Duty Assigned',
            'description' => $this->duty->description,
            'time' => $this->duty->time,
        ];
    }
}