<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AssesementWorkAssignedToSupervisorNotifications;

class NotificationService
{
    public function notifySupervisors($users)
    {
        Notification::send($users, new AssesementWorkAssignedToSupervisorNotifications());
    }
}
