<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Audit - {{ $audit->tema }}</title>
    <style>
        body {
            font-family: "Times New Roman", Times, serif;
            font-size: 13px;
            color: #1F2937;
            padding: 20px 40px;
        }
        .kop {
            text-align: center;
            border-bottom: 2px solid #003366;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }
        .kop h1 {
            font-size: 20px;
            font-weight: bold;
            color: #003366;
            margin: 0;
        }
        .kop p {
            margin: 4px 0 0;
            font-size: 12px;
            color: #4B5563;
        }
        .section-title {
            background-color: #003366;
            color: white;
            padding: 6px 10px;
            margin-top: 24px;
            font-weight: bold;
            font-size: 14px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }
        .table th, .table td {
            border: 1px solid #D1D5DB;
            padding: 8px;
            vertical-align: top;
            text-align: left;
        }
        .photo {
            max-width: 100%;
            height: auto;
        }
        .footer {
            margin-top: 40px;
            text-align: center;
            font-size: 12px;
            color: #6B7280;
        }
    </style>
</head>
<body>

    <div class="kop">
        <h1>Detail Laporan Audit 5S</h1>
        <p>Sistem Audit</p>
    </div>

    <div class="section-title">Informasi Audit</div>
    <table class="table">
        <tr>
            <th>Nama Auditor</th>
            <td>{{ $audit->auditor }}</td>
            <th>Bagian Auditor</th>
            <td>{{ $audit->user->bagian->nama_bagian ?? '-' }}</td>
        </tr>
        <tr>
            <th>Tema Audit</th>
            <td>{{ $audit->tema }}</td>
            <th>Kategori Audit</th>
            <td>{{ $audit->kategori }}</td>
        </tr>
        <tr>
            <th>Bagian yang Diaudit</th>
            <td>{{ $audit->bagian->nama_bagian ?? '-' }}</td>
            <th>Area Temuan</th>
            <td>{{ $audit->lokasi }}</td>
        </tr>
        <tr>
            <th>Tanggal Audit</th>
            <td>{{ \Carbon\Carbon::parse($audit->tanggal_audit)->translatedFormat('d F Y') }}</td>
            <th>Tanggal Verifikasi</th>
            <td>{{ $audit->tanggal_verifikasi ? \Carbon\Carbon::parse($audit->tanggal_verifikasi)->translatedFormat('d F Y') : '-' }}</td>
        </tr>
    </table>

    <div class="section-title">Keterangan Audit</div>
    <table class="table">
        <tr>
            <th>Sebelum</th>
            <td>{{ $audit->keterangan }}</td>
        </tr>
        <tr>
            <th>Sesudah</th>
            <td>{{ $audit->keterangan_sesudah ?? '-' }}</td>
        </tr>
    </table>

    <div class="section-title">Dokumentasi Foto</div>
    <table class="table">
        <tr>
            <th>Foto Sebelum</th>
            <th>Foto Sesudah</th>
        </tr>
        <tr>
            <td>
                @if ($audit->foto_sebelum && file_exists(public_path('storage/' . $audit->foto_sebelum)))
                    <img class="photo" src="{{ public_path('storage/' . $audit->foto_sebelum) }}" alt="Foto Sebelum">
                @else
                    <em>Tidak tersedia</em>
                @endif
            </td>
            <td>
                @if ($audit->foto_sesudah && file_exists(public_path('storage/' . $audit->foto_sesudah)))
                    <img class="photo" src="{{ public_path('storage/' . $audit->foto_sesudah) }}" alt="Foto Sesudah">
                @else
                    <em>Tidak tersedia</em>
                @endif
            </td>
        </tr>
    </table>

    <div class="footer">
        Dokumen ini dihasilkan otomatis melalui Sistem Audit 5S<br>
        &copy; {{ date('Y') }} E-Audit Systems
    </div>

</body>
</html>
