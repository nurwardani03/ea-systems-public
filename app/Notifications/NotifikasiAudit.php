<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;

class NotifikasiAudit extends Notification
{
    use Queueable;

    public $isi;

    public function __construct($isi)
    {
        $this->isi = $isi;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'pesan' => $this->isi,
            'kepada' => $notifiable->name,
        ];
    }
}
