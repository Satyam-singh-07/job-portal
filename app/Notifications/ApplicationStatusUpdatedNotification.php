<?php

namespace App\Notifications;

use App\Models\JobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ApplicationStatusUpdatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected JobApplication $application,
        protected string $oldStatus,
        protected string $newStatus,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $jobTitle = $this->application->job?->title ?? 'Job';

        return (new MailMessage)
            ->subject('Application Status Updated: '.$jobTitle)
            ->greeting('Hello '.($notifiable->first_name ?: 'Candidate').',')
            ->line('Your application status has been updated.')
            ->line('Job: '.$jobTitle)
            ->line('Previous status: '.$this->oldStatus)
            ->line('Current status: '.$this->newStatus)
            ->action('View Applications', route('candidate.applications'))
            ->line('We wish you the best in your hiring journey.');
    }

    public function toArray(object $notifiable): array
    {
        return [
            'application_id' => $this->application->id,
            'job_id' => $this->application->job_id,
            'job_title' => $this->application->job?->title,
            'old_status' => $this->oldStatus,
            'new_status' => $this->newStatus,
            'message' => 'Your application status was updated from '.$this->oldStatus.' to '.$this->newStatus.'.',
            'url' => route('candidate.applications'),
        ];
    }
}
