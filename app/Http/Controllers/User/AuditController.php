<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Audit;
use App\Models\Bagian;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Str;

class AuditController extends Controller
{
    public function dashboard()
    {
        $userId = Auth::id();

        $totalAudit = Audit::where('user_id', $userId)->count();
        $totalSelesai = Audit::where('user_id', $userId)->where('status', 'Close')->count();
        $totalBelum = Audit::where('user_id', $userId)
            ->where(function ($q) {
                $q->where('status', '!=', 'Close')->orWhereNull('status');
            })->count();

        return view('web_user.dashboard', compact('totalAudit', 'totalSelesai', 'totalBelum'));
    }

    public function create()
    {
        $auditBelumClose = Audit::with('bagian')
            ->where('user_id', Auth::id())
            ->where(function ($query) {
                $query->where('status', '!=', 'Close')->orWhereNull('status');
            })->orderBy('created_at', 'desc')->get();

        $bagians = Bagian::all();

        return view('web_user.tambah-audit', compact('auditBelumClose', 'bagians'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'auditor'             => 'required|string|max:100',
            'tema'                => 'required|string|max:200',
            'kategori'            => 'required|string|max:100',
            'bagian_id'           => 'required|exists:bagian,id',
            'lokasi'              => 'nullable|string|max:200',
            'foto_sebelum'        => 'required|image|mimes:jpg,jpeg,png|max:256',
            'keterangan'          => 'nullable|string',
            'tanggal_audit'       => 'required|date',
            'tanggal_verifikasi'  => 'nullable|date|after_or_equal:tanggal_audit',
        ]);

        $validated['user_id'] = Auth::id();

        if ($request->hasFile('foto_sebelum')) {
            $image = $request->file('foto_sebelum');
            $user = Auth::user();
            $filename = 'audit_' . Str::slug($user->name) . '_' . Str::slug($user->bagian->nama_bagian) . '_sebelum_' . time() . '.jpg';
            $path = 'audit/' . $filename;

            $manager = new ImageManager(new Driver());
            $img = $manager->read($image)->toJpeg(75);

            if ($image->getSize() > 500 * 1024) {
                $img = $img->scaleDown(width: 1200);
            }

            $img->save(public_path('storage/' . $path));
            $validated['foto_sebelum'] = $path;
        }

        Audit::create($validated);

        return redirect()->route('audit.create')->with('success', 'Data audit berhasil disimpan!');
    }

    public function show($id)
    {
        $audit = Audit::with('bagian')
            ->where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        return view('web_user.detail-audit', compact('audit'));
    }

    public function updateSesudah(Request $request, $id)
{
    $audit = Audit::where('id', $id)
        ->where('user_id', Auth::id())
        ->firstOrFail();

    $rules = [
        'keterangan_sesudah' => 'required|string',
        'foto_sesudah' => 'required|image|mimes:jpg,jpeg,png|max:256',
    ];

    // Hanya validasi tanggal_verifikasi kalau belum ada di DB
    if (!$audit->tanggal_verifikasi) {
        $rules['tanggal_verifikasi'] = 'required|date|after_or_equal:' . $audit->tanggal_audit;
    }

    $validated = $request->validate($rules);

    $audit->keterangan_sesudah = $validated['keterangan_sesudah'];

    // Set tanggal verifikasi hanya jika belum ditentukan
    if (!$audit->tanggal_verifikasi && isset($validated['tanggal_verifikasi'])) {
        $audit->tanggal_verifikasi = $validated['tanggal_verifikasi'];
    }

    // Proses foto sesudah
    if ($request->hasFile('foto_sesudah')) {
        $image = $request->file('foto_sesudah');
        $user = Auth::user();
        $filename = 'audit_' . Str::slug($user->name) . '_' . Str::slug($user->bagian->nama_bagian) . '_sesudah_' . time() . '.jpg';
        $path = 'audit/' . $filename;

        $manager = new ImageManager(new Driver());
        $img = $manager->read($image)->toJpeg(75);

        if ($image->getSize() > 256 * 1024) {
            $img = $img->scaleDown(width: 1200);
        }

        $img->save(public_path('storage/' . $path));
        $audit->foto_sesudah = $path;
    }

    $audit->status = 'Close';
    $audit->save();

    return redirect()->route('audit.riwayat')->with('success', 'Verifikasi berhasil. Status: Close');
}



    public function riwayat()
    {
        $auditSudahClose = Audit::with('bagian')
            ->where('user_id', Auth::id())
            ->where('status', 'Close')
            ->orderBy('tanggal_audit', 'desc')
            ->get();

        return view('web_user.riwayat-audit', compact('auditSudahClose'));
    }

    public function hasilAudit()
    {
        $user = Auth::user();

        $audits = Audit::with(['user', 'bagian'])
            ->where('bagian_id', $user->bagian_id)
            ->orderBy('tanggal_audit', 'desc')
            ->get();

        $auditBulanIni = Audit::with(['user', 'bagian'])
            ->where('bagian_id', $user->bagian_id)
            ->whereMonth('tanggal_audit', Carbon::now()->month)
            ->whereYear('tanggal_audit', Carbon::now()->year)
            ->orderBy('tanggal_audit', 'desc')
            ->get();

        return view('web_user.hasil-audit', compact('audits', 'auditBulanIni'));
    }

    public function hasilAuditShow($id)
    {
        $audit = Audit::with(['user.bagian', 'bagian'])->findOrFail($id);
        return view('web_user.detail-hasil-audit', compact('audit'));
    }

    public function notifikasi()
    {
        $notifikasi = Notification::where('user_id', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('web_user.notifikasi', compact('notifikasi'));
    }
}
