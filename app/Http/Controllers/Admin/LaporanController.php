<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Audit;
use App\Models\User;
use App\Models\Bagian;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // Ambil bulan audit & verifikasi dari request atau default bulan ini
        $bulanAudit = $request->bulan_audit ?? Carbon::now()->format('Y-m');
        $bulanVerifikasi = $request->bulan_verifikasi ?? Carbon::now()->format('Y-m');
        $bagian = $request->bagian;

        // Konversi bulan ke tanggal awal & akhir
        try {
            $startAudit = Carbon::createFromFormat('Y-m', $bulanAudit)->startOfMonth();
            $endAudit = Carbon::createFromFormat('Y-m', $bulanAudit)->endOfMonth();
        } catch (\Exception $e) {
            $startAudit = Carbon::now()->startOfMonth();
            $endAudit = Carbon::now()->endOfMonth();
        }

        try {
            $startVerif = Carbon::createFromFormat('Y-m', $bulanVerifikasi)->startOfMonth();
            $endVerif = Carbon::createFromFormat('Y-m', $bulanVerifikasi)->endOfMonth();
        } catch (\Exception $e) {
            $startVerif = Carbon::now()->startOfMonth();
            $endVerif = Carbon::now()->endOfMonth();
        }

        // Ambil semua bagian
        $allBagian = Bagian::orderBy('nama_bagian')->get();

        // Ambil data audit yang masuk salah satu periode audit atau verifikasi
        $audits = Audit::with('user', 'bagian')
            ->whereHas('user')
            ->whereHas('bagian')
            ->when($bagian, fn($q) =>
                $q->whereHas('bagian', fn($sub) =>
                    $sub->where('nama_bagian', $bagian)
                )
            )
            ->where(function ($query) use ($startAudit, $endAudit, $startVerif, $endVerif) {
                $query->whereBetween('tanggal_audit', [$startAudit, $endAudit])
                      ->orWhereBetween('tanggal_verifikasi', [$startVerif, $endVerif]);
            })
            ->orderBy('tanggal_audit', 'desc')
            ->get();

        // Grafik Bar & Pie: berdasarkan bagian dari hasil filter
        $barData = $audits->groupBy(fn($a) => $a->bagian->nama_bagian ?? '-')
            ->map(fn($group) => $group->count());
        $pieData = $barData;

        // Temuan paling sedikit
        $leastFindings = $barData->sort()->take(1);
        $leastFindingsBagian = $leastFindings->map(function ($jumlah, $nama) {
            return [
                'nama' => $nama,
                'jumlah' => $jumlah
            ];
        })->first();

        // Kirim ke view
        return view('admin.laporan', [
            'audits'              => $audits,
            'barData'             => $barData,
            'pieData'             => $pieData,
            'bulanAudit'          => $bulanAudit,
            'bulanVerifikasi'     => $bulanVerifikasi,
            'selectedBagian'      => $bagian,
            'allBagian'           => $allBagian,
            'leastFindingsBagian' => $leastFindingsBagian,
        ]);
    }
}
