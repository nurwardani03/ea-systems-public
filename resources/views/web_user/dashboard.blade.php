@extends('web_user.layouts.app')

@section('title', 'Dashboard Auditor')

@section('content')
<div class="min-h-screen flex flex-col items-center px-4">
    <div class="w-full max-w-6xl flex-1">

        {{-- Selamat Datang --}}
        <div class="bg-white rounded-lg shadow p-6 text-center mb-6">
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">
                Selamat Datang di <span class="text-blue-600">E-Audit Systems</span>
            </h2>
            <p class="text-gray-500 text-base">
                Kontrol dan evaluasi lebih baik dengan sistem audit
            </p>
            <p class="text-xs italic text-gray-400 mt-2">
                "Audit bukan hanya tugas, tapi juga tanggung jawab bersama."
            </p>
        </div>

        {{-- Statistik --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
            {{-- Total Audit Saya --}}
            <div class="bg-blue-100 text-blue-700 p-5 rounded-lg shadow flex items-center justify-between">
                <div>
                    <div class="text-sm font-semibold">Total Audit Saya</div>
                    <div class="text-2xl font-bold">{{ $totalAudit }}</div>
                </div>
                <i class="fas fa-clipboard-list text-3xl"></i>
            </div>

            {{-- Audit Close --}}
            <div class="bg-green-100 text-green-700 p-5 rounded-lg shadow flex items-center justify-between">
                <div>
                    <div class="text-sm font-semibold">Audit Close</div>
                    <div class="text-2xl font-bold">{{ $totalSelesai }}</div>
                </div>
                <i class="fas fa-check-circle text-3xl"></i>
            </div>

            {{-- Audit Open --}}
            <div class="bg-yellow-100 text-yellow-700 p-5 rounded-lg shadow flex items-center justify-between">
                <div>
                    <div class="text-sm font-semibold">Audit Open</div>
                    <div class="text-2xl font-bold">{{ $totalBelum }}</div>
                </div>
                <i class="fas fa-hourglass-half text-3xl"></i>
            </div>
        </div>

        {{-- Aksi Cepat --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
            <a href="{{ route('audit.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 rounded-lg text-center shadow transition">
                Tambah Audit
            </a>
            <a href="{{ route('audit.riwayat') }}" class="bg-gray-600 hover:bg-gray-700 text-white font-semibold py-3 rounded-lg text-center shadow transition">
                Riwayat Audit
            </a>
            <a href="{{ route('notifikasi.index') }}" class="bg-green-600 hover:bg-green-700 text-white font-semibold py-3 rounded-lg text-center shadow transition">
                Notifikasi
            </a>
        </div>

        {{-- Carousel Gambar Audit --}}
        <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
            <div class="relative w-full h-96 overflow-hidden">
                @for ($i = 1; $i <= 4; $i++)
                    <div class="carousel-slide absolute inset-0 transition-opacity duration-700 ease-in-out {{ $i === 1 ? 'opacity-100' : 'opacity-0' }}">
                        <img src="{{ asset('images/audit' . $i . '.jpg') }}" alt="Audit {{ $i }}"
                             class="object-cover w-full h-full">
                    </div>
                @endfor
            </div>
        </div>

    </div>


@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", () => {
    const slides = document.querySelectorAll(".carousel-slide");
    let idx = 0;
    setInterval(() => {
        slides.forEach((s, i) => s.style.opacity = (i === idx ? '1' : '0'));
        idx = (idx + 1) % slides.length;
    }, 4000);
});
</script>
@endpush
