<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Audit;
use App\Models\Bagian;
use App\Models\User;
use Carbon\Carbon;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Audit::with('bagian');

        // FILTER
        if ($request->tanggal_awal && $request->tanggal_akhir) {
            $query->whereBetween('tanggal_audit', [$request->tanggal_awal, $request->tanggal_akhir]);
        }

        if ($request->bagian_id) {
            $query->where('bagian_id', $request->bagian_id); // ✅ Perbaikan: bagian_id
        }

        if ($request->kategori) {
            $query->where('kategori', $request->kategori);
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        $audits = $query->latest()->get();

        // CHART DATA
        $auditPerBulan = $audits->groupBy(function ($a) {
            return Carbon::parse($a->tanggal_audit)->format('M Y');
        })->map->count();

        $auditPerBagian = $audits->groupBy('bagian.nama_bagian')->map(function ($group, $key) {
            return (object)[
                'nama_bagian' => $key,
                'total' => $group->count()
            ];
        });

        $auditTimeline = $audits->sortBy('tanggal_audit')->groupBy('tanggal_audit')->map->count();

        $bagians = Bagian::all();

        return view('web_user.laporan', compact(
            'audits',
            'bagians',
            'auditPerBulan',
            'auditPerBagian',
            'auditTimeline'
        ));
    }
}
