<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Audit;
use Barryvdh\DomPDF\Facade\Pdf;

class AuditExportController extends Controller
{
    public function exportPDF($id)
    {
        $audit = Audit::with(['user.bagian', 'bagian'])->findOrFail($id);
        $pdf = Pdf::loadView('admin.exports.audit-pdf', compact('audit'))->setPaper('A4', 'portrait');

        return $pdf->download('audit_' . $id . '.pdf');
    }
    
    public function setAllVerifikasi(Request $request)
{
    $request->validate([
        'audit_ids' => 'required|string',
        'tanggal_verifikasi' => 'required|date',
    ]);

    $ids = explode(',', $request->audit_ids);
    $tanggal = $request->tanggal_verifikasi;

    foreach ($ids as $id) {
        $audit = Audit::find($id);
        if ($audit && !$audit->tanggal_verifikasi) {
            $audit->tanggal_verifikasi = $tanggal;
            $audit->status = 'Close';
            $audit->save();

            // Kirim notifikasi ke user (auditor)
            Notification::create([
                'user_id' => $audit->user_id,
                'pesan' => "Audit tema \"{$audit->tema}\" telah diverifikasi pada tanggal " . \Carbon\Carbon::parse($tanggal)->format('d M Y') . ".",
                'jenis' => 'verifikasi',
            ]);
        }
    }

    return back()->with('success', 'Tanggal verifikasi berhasil ditentukan dan notifikasi dikirim.');
}

}
