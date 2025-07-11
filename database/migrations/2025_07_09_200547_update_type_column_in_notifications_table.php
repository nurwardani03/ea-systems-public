<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            // tambahkan default value 'App\Notifications\NotifikasiAudit' pada kolom 'type'
            $table->string('type')->default('App\\Notifications\\NotifikasiAudit')->change();
        });
    }

    public function down(): void
    {
        Schema::table('notifications', function (Blueprint $table) {
            // hilangkan default value
            $table->string('type')->change();
        });
    }
};
