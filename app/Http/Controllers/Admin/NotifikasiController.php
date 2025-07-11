<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Notifications\PesanNotifikasi;
use Illuminate\Support\Facades\Notification as NotificationFacade;

class NotifikasiController extends Controller
{
    public function index()
    {
        // Ambil riwayat notifikasi yang dikirim admin
        $notifikasi = auth()->user()->notifications()->latest()->get();

        // Template pesan
        $templates = [
            'jadwal_audit'       => 'Audit 5S akan dilaksanakan pada tanggal: [TANGGAL_AUDIT]. Mohon persiapannya.',
            'jadwal_verifikasi'  => 'Verifikasi hasil audit akan dilakukan pada: [TANGGAL_VERIFIKASI]. Pastikan seluruh data lengkap.',
            'pemberitahuan_umum' => 'Mohon perhatian seluruh auditor, berikut pemberitahuan penting: [ISI_PESAN].',
        ];

        return view('admin.notifikasi', compact('notifikasi', 'templates'));
    }

    public function kirim(Request $request)
    {
        $request->validate([
            'isi_pesan'         => 'required|string',
            'selected_subject'  => 'required|string',
            'emails'            => 'array',
            'emails.*'          => 'nullable|email',
            'foto'              => 'nullable|image|max:256',
        ]);

        // Simpan foto jika ada
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $fotoPath = $request->file('foto')->store('notifikasi', 'public');
        }

        // Judul notifikasi sesuai subjek
        $judul = match($request->selected_subject) {
            'audit'      => 'Jadwal Audit',
            'verifikasi' => 'Jadwal Verifikasi',
            'umum'       => 'Pemberitahuan Umum',
            default      => 'Notifikasi Baru',
        };

        // Data notifikasi
        $data = [
            'judul'     => $judul,
            'isi_pesan' => $request->isi_pesan,
            'foto'      => $fotoPath,
            'icon'      => '📢',
            'warna'     => 'yellow',
        ];

        // Kirim ke user
        $emails = array_filter($request->emails ?? []);
        $users = count($emails) ? User::whereIn('email', $emails)->get() : User::all();

        if ($users->isEmpty()) {
            return back()->with('error', 'Tidak ada user ditemukan.');
        }

        // Kirim notifikasi ke user
        NotificationFacade::send($users, new PesanNotifikasi($data));

        // Kirim juga ke admin agar muncul di riwayat
        auth()->user()->notify(new PesanNotifikasi($data));

        return redirect()->back()->with('success', 'Notifikasi berhasil dikirim ke ' . $users->count() . ' user.');
    }
}
