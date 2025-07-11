<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Audit;
use App\Models\Bagian;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Ambil bulan dari request atau default ke bulan ini (format: Y-m)
        $bulanAudit = $request->bulan_audit ?? Carbon::now()->format('Y-m');

        try {
            $startAudit = Carbon::createFromFormat('Y-m', $bulanAudit)->startOfMonth();
            $endAudit   = Carbon::createFromFormat('Y-m', $bulanAudit)->endOfMonth();
        } catch (\Exception $e) {
            $startAudit = Carbon::now()->startOfMonth();
            $endAudit   = Carbon::now()->endOfMonth();
        }

        // Statistik utama
        $totalAuditor   = User::count();
        $auditSelesai   = Audit::where('status', 'Close')->count();
        $auditProses    = Audit::where(function ($q) {
            $q->whereNull('status')->orWhere('status', 'Open');
        })->count();
        $totalAuditAll  = Audit::count();

        // Ambil audit bulan ini (yang punya bagian)
        $auditsBulanIni = Audit::with('bagian')
            ->whereHas('bagian') // pastikan relasi tidak null
            ->whereBetween('tanggal_audit', [$startAudit, $endAudit])
            ->get();

        // Hitung temuan per bagian
        $bagianPalingSedikit = $auditsBulanIni
            ->groupBy(fn($audit) => $audit->bagian->nama_bagian)
            ->map(fn($group) => $group->count())
            ->sort() // urut naik (sedikit ke banyak)
            ->map(fn($jumlah, $nama) => (object)[
                'nama_bagian'   => $nama,
                'jumlah_temuan' => $jumlah,
            ])
            ->take(5)
            ->values(); // ubah ke numerik array

        return view('admin.dashboard', compact(
            'totalAuditor',
            'auditSelesai',
            'auditProses',
            'totalAuditAll',
            'bagianPalingSedikit',
            'bulanAudit',
            'startAudit'
        ));
    }
}
