<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Audit extends Model
{
    use HasFactory;

    protected $table = 'audit';

    protected $fillable = [
        'user_id',
        'auditor',
        'tema',
        'kategori',
        'bagian_id',
        'lokasi',
        'foto_sebelum',
        'keterangan',
        'tanggal_audit',
        'tanggal_verifikasi',
        'keterangan_sesudah',
        'foto_sesudah',
        'status',
    ];

    public function bagian()
    {
        return $this->belongsTo(Bagian::class, 'bagian_id');
    }

    public function user()
    {
    return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

}
