<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    // Guard khusus untuk admin
    protected $guard = 'admin';

    // Menentukan nama tabel secara eksplisit
    protected $table = 'admin';

    // Kolom yang boleh diisi (fillable)
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    // Kolom yang disembunyikan saat model di-serialize
    protected $hidden = [
        'password',
        'remember_token',
    ];
}
