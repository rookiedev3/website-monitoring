<?php

namespace App\Notifications;

use App\Models\Incident;
use App\Models\Website;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WebsiteUpNotification extends Notification
{
    use Queueable;

    public $website;

    public $incident;

    public $duration;

    public function __construct(Website $website, Incident $incident, string $duration)
    {
        $this->website = $website;
        $this->incident = $incident;
        $this->duration = $duration;
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
            ->success()
            ->subject("[RESOLVED] Website {$this->website->website_name} Kembali Normal")
            ->greeting('Yth. Tim,')
            ->line('Berikut ringkasan insiden yang telah diselesaikan:')
            ->line("**Monitor** : {$this->website->website_name}")
            ->line("**URL** : {$this->website->url}")
            ->line("**Status Insiden** : Resolved (diselesaikan otomatis)")
            ->line("**Durasi Downtime** : {$this->duration}")
            ->action('Lihat Detail Insiden', $url)
            ->line('Hormat kami,')
            ->salutation('Website Monitoring System');
    }

    public function toDatabase($notifiable)
    {
        return [
            'type' => 'website_up',
            'color' => 'success', // Penanda Warna Hijau
            'website_id' => $this->website->id,
            'website_name' => $this->website->website_name,
            'domain' => $this->website->url,
            'duration' => $this->duration,
            'incident_id' => $this->incident->id,
            'is_resolved' => true,
            'action_url' => route('incidents.show', $this->incident->id),
            'message' => "Website {$this->website->website_name} telah kembali normal.",
        ];
    }
}
