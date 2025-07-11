<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PesanNotifikasi extends Notification
{
    use Queueable;

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        return [
            'judul'     => $this->data['judul'],
            'isi_pesan' => $this->data['isi_pesan'],
            'foto'      => $this->data['foto'] ?? null,
            'icon'      => $this->data['icon'] ?? '📢',
            'warna'     => $this->data['warna'] ?? 'gray',
        ];
    }
}
