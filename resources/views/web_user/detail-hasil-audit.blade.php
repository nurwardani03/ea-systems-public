@extends('web_user.layouts.app')
@section('title', 'Detail Hasil Audit')

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow-md rounded-lg p-6">
    <h2 class="text-xl font-bold text-blue-700 mb-6 border-b pb-2">Detail Hasil Audit</h2>

    <div class="border border-gray-200 rounded-md p-4 mb-8 bg-gray-50">
        <div class="grid grid-cols-2 gap-4">
            <!-- Kiri -->
            <div>
                <label class="text-sm font-medium text-gray-600">Nama Auditor</label>
                <div class="text-gray-800">{{ $audit->auditor }}</div>
            </div>
            <!-- Kanan -->
            <div>
                <label class="text-sm font-medium text-gray-600">Bagian Auditor</label>
                <div class="text-gray-800">{{ $audit->user->bagian->nama_bagian ?? '-' }}</div>
            </div>
            <!-- Kiri -->
            <div>
                <label class="text-sm font-medium text-gray-600">Tema Audit</label>
                <div class="text-gray-800">{{ $audit->tema }}</div>
            </div>
            <!-- Kanan -->
            <div>
                <label class="text-sm font-medium text-gray-600">Kategori Audit</label>
                <div class="text-gray-800">{{ $audit->kategori }}</div>
            </div>
            <!-- Kiri -->
            <div>
                <label class="text-sm font-medium text-gray-600">Bagian yang Diaudit</label>
                <div class="text-gray-800">{{ $audit->bagian->nama_bagian ?? '-' }}</div>
            </div>
            <!-- Kanan -->
            <div>
                <label class="text-sm font-medium text-gray-600">Area Temuan</label>
                <div class="text-gray-800">{{ $audit->lokasi }}</div>
            </div>
            <!-- Kiri -->
            <div>
                <label class="text-sm font-medium text-gray-600">Tanggal Audit</label>
                <div class="text-gray-800">
                    {{ \Carbon\Carbon::parse($audit->tanggal_audit)->translatedFormat('d F Y') }}
                </div>
            </div>
            <!-- Kanan -->
            <div>
                <label class="text-sm font-medium text-gray-600">Tanggal Verifikasi</label>
                <div class="text-gray-800">
                    {{ $audit->tanggal_verifikasi ? \Carbon\Carbon::parse($audit->tanggal_verifikasi)->translatedFormat('d F Y') : '-' }}
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-6">
        <div>
            <label class="text-sm font-medium text-gray-600">Keterangan Sebelum</label>
            <div class="border rounded p-3 text-gray-700 bg-gray-50 min-h-[100px]">
                {{ $audit->keterangan }}
            </div>
        </div>
        <div>
            <label class="text-sm font-medium text-gray-600">Keterangan Sesudah</label>
            <div class="border rounded p-3 text-gray-700 bg-gray-50 min-h-[100px]">
                {{ $audit->keterangan_sesudah ?? '-' }}
            </div>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-6 mt-6">
        <div>
            <label class="text-sm font-medium text-gray-600">Foto Sebelum</label>
            @if ($audit->foto_sebelum && file_exists(public_path('storage/' . $audit->foto_sebelum)))
                <img src="{{ asset('storage/' . $audit->foto_sebelum) }}"
                     alt="Foto Sebelum"
                     class="mt-2 rounded border w-full object-contain max-h-72 bg-gray-100">
            @else
                <div class="text-red-500 mt-2">Foto sebelum tidak ditemukan.</div>
            @endif
        </div>
        <div>
            <label class="text-sm font-medium text-gray-600">Foto Sesudah</label>
            @if ($audit->foto_sesudah && file_exists(public_path('storage/' . $audit->foto_sesudah)))
                <img src="{{ asset('storage/' . $audit->foto_sesudah) }}"
                     alt="Foto Sesudah"
                     class="mt-2 rounded border w-full object-contain max-h-72 bg-gray-100">
            @else
                <div class="text-gray-500 mt-2">Belum ada foto sesudah.</div>
            @endif
        </div>
    </div>

    <div class="mt-8">
        <a href="{{ url()->previous() }}"
           class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded shadow">
            &larr; Kembali
        </a>
    </div>
</div>
@endsection
