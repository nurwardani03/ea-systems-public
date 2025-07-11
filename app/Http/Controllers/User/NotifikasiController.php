<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class NotifikasiController extends Controller
{
    /**
     * Menampilkan semua notifikasi milik user yang login.
     */
    public function index()
    {
        $notifications = Auth::user()
            ->notifications() // relasi dari trait Notifiable
            ->orderBy('created_at', 'desc')
            ->get();

        return view('web_user.notifikasi', [
            'notifikasi' => $notifications
        ]);
    }

    /**
     * Menampilkan detail notifikasi (juga otomatis tandai sebagai dibaca).
     */
    public function show($id)
{
    $notification = Auth::user()->notifications()->findOrFail($id);

    // Tandai sebagai sudah dibaca jika belum
    if (is_null($notification->read_at)) {
        $notification->markAsRead();
    }

    return view('web_user.lihat-notifikasi', [
        'notif' => $notification
    ]);
}


    /**
     * Tandai satu notifikasi sebagai sudah dibaca.
     */
    public function baca($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->markAsRead();

        return redirect()->back()->with('success', 'Notifikasi ditandai sebagai dibaca.');
    }

    /**
     * Tandai semua notifikasi sebagai sudah dibaca.
     */
    public function bacaSemua()
    {
        Auth::user()->unreadNotifications->markAsRead();

        return redirect()->back()->with('success', 'Semua notifikasi ditandai sebagai dibaca.');
    }

    /**
     * Hapus notifikasi tertentu.
     */
    public function hapus($id)
    {
        $notification = Auth::user()->notifications()->findOrFail($id);
        $notification->delete();

        return redirect()->back()->with('success', 'Notifikasi berhasil dihapus.');
    }

    /**
     * Hapus semua notifikasi.
     */
    public function hapusSemua()
    {
        Auth::user()->notifications()->delete();

        return redirect()->back()->with('success', 'Semua notifikasi berhasil dihapus.');
    }
}
