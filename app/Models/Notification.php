<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str; // Import Str facade untuk UUID

class Notification extends Model
{
    // Menentukan bahwa primary key adalah UUID (string)
    protected $keyType = 'string';

    // Menentukan bahwa primary key tidak auto-incrementing
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'audit_id', // Pastikan ini ada di fillable
        'jenis',
        'judul',
        'isi',
        'icon',
        'warna',
        'status_baca', // Pastikan kolom ini ada di database jika digunakan
        // Jika Anda menggunakan kolom 'type', 'notifiable_type', 'notifiable_id', 'data', 'foto', 'read_at'
        // dari struktur tabel notifications Laravel default, Anda mungkin perlu menambahkannya di sini juga.
        // Contoh:
        // 'type',
        // 'notifiable_type',
        // 'notifiable_id',
        // 'data',
        // 'foto',
        // 'read_at',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        // Mengatur UUID secara otomatis saat membuat model baru jika ID kosong
        static::creating(function ($model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = (string) Str::uuid();
            }
        });
    }

    /**
     * Get the user that owns the notification.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the audit that the notification belongs to.
     */
    public function audit()
    {
        return $this->belongsTo(Audit::class);
    }

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        // 'data' => 'array', // Aktifkan jika kolom 'data' menyimpan JSON
        // 'read_at' => 'datetime', // Aktifkan jika kolom 'read_at' adalah timestamp
    ];
}
