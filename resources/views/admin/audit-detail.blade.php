@extends('admin.layouts.app')
@section('title', 'Detail Audit')

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow-md rounded-lg p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-xl font-bold text-blue-700 border-b pb-2">Detail Audit</h2>
        <div class="space-x-2">
            <a href="{{ route('admin.audit.export.pdf', $audit->id) }}"
               class="inline-flex items-center bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded shadow text-sm font-medium transition">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M17 8h-1V3a1 1 0 00-1-1H5a1 1 0 00-1 1v14a1 1 0 001 1h10a1 1 0 001-1v-5h1v5a2 2 0 01-2 2H5a2 2 0 01-2-2V3a2 2 0 012-2h10a2 2 0 012 2v5z"/>
                    <path d="M8.5 12H7v-1h1.5a.5.5 0 100-1H7v-1h1.5a1.5 1.5 0 110 3zM11.5 12H10v-3h1.5a1.5 1.5 0 110 3zM13 11h1v1h1v-1h1v-1h-1v-1h-1v1h-1v1z"/>
                </svg>
                Export PDF
            </a>
            <button onclick="window.print()"
               class="inline-flex items-center bg-gray-700 hover:bg-black text-white px-4 py-2 rounded shadow text-sm font-medium transition">
                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M5 4V2h10v2h1a1 1 0 011 1v5h-2V6H6v4H4V5a1 1 0 011-1h1zM4 11h12v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zm2 2v2h8v-2H6z"/>
                </svg>
                Print
            </button>
        </div>
    </div>

    <div class="border border-gray-200 rounded-md p-4 mb-8 bg-gray-50 print:border-0">
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="text-sm font-medium text-gray-600">Nama Auditor</label>
                <div class="text-gray-800">{{ $audit->auditor }}</div>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-600">Bagian Auditor</label>
                <div class="text-gray-800">{{ $audit->user->bagian->nama_bagian ?? '-' }}</div>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-600">Tema Audit</label>
                <div class="text-gray-800">{{ $audit->tema }}</div>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-600">Kategori Audit</label>
                <div class="text-gray-800">{{ $audit->kategori }}</div>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-600">Bagian yang Diaudit</label>
                <div class="text-gray-800">{{ $audit->bagian->nama_bagian ?? '-' }}</div>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-600">Area Temuan</label>
                <div class="text-gray-800">{{ $audit->lokasi }}</div>
            </div>
            <div>
                <label class="text-sm font-medium text-gray-600">Tanggal Audit</label>
                <div class="text-gray-800">
                    {{ \Carbon\Carbon::parse($audit->tanggal_audit)->translatedFormat('d F Y') }}
                </div>
            </div>
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

    <div class="grid grid-cols-2 gap-6 mt-6 print:hidden">
        <div>
            <label class="text-sm font-medium text-gray-600">Foto Sebelum</label>
            @if ($audit->foto_sebelum && file_exists(public_path('storage/' . $audit->foto_sebelum)))
                <img src="{{ asset('storage/' . $audit->foto_sebelum) }}" alt="Foto Sebelum"
                     class="mt-2 rounded border w-full object-contain max-h-72 bg-gray-100">
            @else
                <div class="text-red-500 mt-2">Foto sebelum tidak ditemukan.</div>
            @endif
        </div>
        <div>
            <label class="text-sm font-medium text-gray-600">Foto Sesudah</label>
            @if ($audit->foto_sesudah && file_exists(public_path('storage/' . $audit->foto_sesudah)))
                <img src="{{ asset('storage/' . $audit->foto_sesudah) }}" alt="Foto Sesudah"
                     class="mt-2 rounded border w-full object-contain max-h-72 bg-gray-100">
            @else
                <div class="text-gray-500 mt-2 italic">Belum ada foto sesudah.</div>
            @endif
        </div>
    </div>

    <div class="mt-8 print:hidden">
        <a href="{{ route('admin.audit') }}"
           class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded shadow">
            &larr; Kembali
        </a>
    </div>
</div>
@endsection
