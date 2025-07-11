@extends('web_user.layouts.app')
@section('title', 'Detail Notifikasi')

@section('content')
<div class="p-4 max-w-3xl mx-auto">

    {{-- Header judul --}}
    <h1 class="text-xl sm:text-2xl font-semibold text-gray-800 mb-4 border-b pb-2 flex items-center gap-2">
        📢 {{ $notif->data['judul'] ?? 'Notifikasi' }}
        @if(is_null($notif->read_at))
            <span class="ml-2 inline-block bg-blue-600 text-white text-[10px] px-1.5 py-0.5 rounded">Baru</span>
        @endif
    </h1>

    {{-- Konten notifikasi --}}
    <div class="bg-white shadow-md rounded-xl p-6 space-y-4">
        
        {{-- Isi pesan --}}
        <div class="text-gray-700 text-sm leading-relaxed whitespace-pre-line border-l-4 border-blue-500 pl-4">
            {{ $notif->data['isi_pesan'] ?? '-' }}
        </div>

        {{-- Lampiran foto (jika ada) --}}
        @if (!empty($notif->data['foto']))
            <div>
                <img src="{{ asset('storage/' . $notif->data['foto']) }}" 
                     alt="Lampiran" class="w-full max-w-md mx-auto rounded-lg shadow border">
            </div>
        @endif

        {{-- Info tanggal --}}
        <p class="text-xs text-gray-500 text-right">
            📅 Dikirim: {{ \Carbon\Carbon::parse($notif->created_at)->format('d M Y H:i') }}
        </p>
    </div>

    {{-- Tombol kembali --}}
    <div class="mt-6">
        <a href="{{ route('notifikasi.index') }}"
           class="inline-flex items-center px-3 py-2 bg-blue-600 text-white text-sm font-medium rounded hover:bg-blue-700 transition-colors">
            ← Kembali ke daftar notifikasi
        </a>
    </div>
</div>
@endsection
