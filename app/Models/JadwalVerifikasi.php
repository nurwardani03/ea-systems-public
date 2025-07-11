<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalVerifikasi extends Model
{
    protected $table = 'jadwal_verifikasi';

    protected $fillable = [
        'audit_id',
        'tanggal_verifikasi',
    ];

    public function audit()
    {
        return $this->belongsTo(Audit::class);
    }
}
