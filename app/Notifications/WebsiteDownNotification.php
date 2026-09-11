<?php

namespace App\Notifications;

use App\Models\Incident;
use App\Models\Website;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WebsiteDownNotification extends Notification
{
    use Queueable;

    public $website;

    public $incident;

    public $errorType;

    public $startTime;

    public function __construct(Website $website, Incident $incident, string $errorType, string $startTime)
    {
        $this->website = $website;
        $this->incident = $incident;
        $this->errorType = $errorType;
        $this->startTime = $startTime;
    }

    public function via($notifiable)
    {
        return $notifiable->email_notifications_enabled
            ? ['database', 'mail']
            : ['database'];
    }

    public function toMail($notifiable)
    {
        $url = route('dashboard.show', $this->website->id);

        return (new MailMessage)
            ->error()
            ->subject("[ALERT] Website {$this->website->website_name} Mengalami Gangguan")
            ->greeting('Yth. Tim,')
            ->line('Berikut ringkasan insiden yang terdeteksi pada monitor Anda:')
            ->line("**Monitor** : {$this->website->website_name}")
            ->line("**URL** : {$this->website->url}")
            ->line("**Root Cause** : {$this->errorType}")
            ->line("**Waktu Mulai** : {$this->startTime}")
            ->action('Lihat Detail Insiden', $url)
            ->line('Mohon segera dilakukan penanganan teknis.')
            ->line('Hormat kami,')
            ->salutation('Website Monitoring System');
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'website_down',
            'color' => 'danger', // Penanda Warna Merah
            'website_id' => $this->website->id,
            'website_name' => $this->website->website_name,
            'domain' => $this->website->url,
            'error_type' => $this->errorType,
            'start_time' => $this->startTime,
            'incident_id' => $this->incident->id,
            'action_url' => route('incidents.show', $this->incident->id),
            'message' => "Website {$this->website->website_name} terdeteksi DOWN.",
        ];
    }
}
