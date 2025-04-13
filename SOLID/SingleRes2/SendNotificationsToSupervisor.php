<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\SupervisorService;
use App\Services\NotificationService;

class SendNotificationsToSupervisor extends Command
{
    protected $signature = 'supervisor:notifications';
    protected $description = 'Send notification to supervisors';

    protected SupervisorService $supervisorService;
    protected NotificationService $notificationService;

    public function __construct(
        SupervisorService $supervisorService,
        NotificationService $notificationService
    ) {
        parent::__construct();
        $this->supervisorService = $supervisorService;
        $this->notificationService = $notificationService;
    }

    public function handle(): void
    {
        $supervisors = $this->supervisorService->getSupervisors();
        $this->notificationService->notifySupervisors($supervisors);

        $this->info("Notifications sent successfully.");
    }
}
