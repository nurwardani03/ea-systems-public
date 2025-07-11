<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Audit;
use App\Models\Notification;
use App\Models\Bagian;
use Carbon\Carbon;

class AuditController extends Controller
{
    public function index(Request $request)
    {
        $now = Carbon::now();
        $bulanIni = $now->format('Y-m');
        $bulanKemarin = $now->copy()->subMonth()->format('Y-m');

        // Cek apakah saat ini bulan audit
        $isBulanAudit = Audit::where('tanggal_audit', 'like', "$bulanIni%")->exists();

        // Audit bulan ini
        $auditBulanIni = Audit::with('bagian')
            ->where('tanggal_audit', 'like', "$bulanIni%")
            ->latest()
            ->get();

        // Audit bulan kemarin (untuk verifikasi)
        $auditBulanKemarin = collect(); // default kosong

        if (!$isBulanAudit) {
            $auditBulanKemarin = Audit::with('bagian')
                ->where('tanggal_audit', 'like', "$bulanKemarin%")
                ->whereNotNull('tanggal_verifikasi')
                ->latest()
                ->get();
        }

        // Ambil semua bagian untuk dropdown filter
        $allBagian = Bagian::orderBy('nama_bagian')->get();

        // Ambil filter dari request
        $bulanRiwayat = $request->bulan_riwayat;
        $bagianRiwayat = $request->bagian_riwayat;

        // Query riwayat audit dengan filter
        $riwayatAudit = Audit::with('bagian')
            ->whereNotNull('tanggal_audit')
            ->when($bulanRiwayat, function ($query, $bulan) {
                $start = Carbon::parse($bulan)->startOfMonth();
                $end = Carbon::parse($bulan)->endOfMonth();
                $query->whereBetween('tanggal_audit', [$start, $end]);
            })
            ->when($bagianRiwayat, function ($query, $bagian) {
                $query->whereHas('bagian', fn($q) => $q->where('nama_bagian', $bagian));
            })
            ->latest()
            ->get();

        return view('admin.audit', compact(
            'isBulanAudit',
            'auditBulanIni',
            'auditBulanKemarin',
            'riwayatAudit',
            'allBagian'
        ));
    }

    public function show($id)
    {
        $audit = Audit::with('bagian')->findOrFail($id);
        return view('admin.audit-detail', compact('audit'));
    }

    public function tentukanVerifikasi(Request $request, $id)
    {
        $request->validate([
            'tanggal_verifikasi' => 'required|date|after_or_equal:today',
        ]);

        DB::transaction(function () use ($id, $request) {
            $audit = Audit::findOrFail($id);

            // Skip kalau tidak ada user_id
            if (!$audit->user_id) return;

            // Update tanggal verifikasi
            $audit->update([
                'tanggal_verifikasi' => $request->tanggal_verifikasi,
            ]);

            // Kirim notifikasi
            Notification::create([
                'user_id' => $audit->user_id,
                'audit_id' => $audit->id,
                'jenis' => 'verifikasi',
                'judul' => '📅 Jadwal Verifikasi Audit',
                'isi' => 'Audit dengan tema "' . $audit->tema . '" akan diverifikasi pada ' .
                    Carbon::parse($request->tanggal_verifikasi)->translatedFormat('d F Y') . '. Jangan lupa dipersiapkan ya!',
                'icon' => '🔍',
                'warna' => 'blue',
            ]);
        });

        return redirect()->route('admin.audit')->with('success', 'Tanggal verifikasi berhasil ditentukan & notifikasi dikirim.');
    }

    public function setAllVerifikasi(Request $request)
    {
        $request->validate([
            'audit_ids' => 'required|string',
            'tanggal_verifikasi' => 'required|date|after_or_equal:today',
        ]);

        $ids = explode(',', $request->input('audit_ids'));

        try {
            Audit::whereIn('id', $ids)->update([
                'tanggal_verifikasi' => $request->input('tanggal_verifikasi'),
            ]);

            return redirect()->back()->with('success', 'Tanggal verifikasi audit berhasil ditentukan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan tanggal verifikasi: ' . $e->getMessage());
        }
    }

    public function setAllAudit(Request $request)
    {
        $request->validate([
            'audit_ids' => 'required|string',
            'tanggal_audit' => 'required|date|after_or_equal:today',
        ]);

        $ids = explode(',', $request->input('audit_ids'));

        try {
            Audit::whereIn('id', $ids)->update([
                'tanggal_audit' => $request->input('tanggal_audit'),
            ]);

            return redirect()->back()->with('success', 'Tanggal audit berhasil ditentukan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan tanggal audit: ' . $e->getMessage());
        }
    }
}
