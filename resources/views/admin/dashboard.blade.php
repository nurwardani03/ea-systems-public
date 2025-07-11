@extends('admin.layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
@php
    use Illuminate\Support\Facades\Auth;
@endphp

<div class="min-h-screen flex flex-col">
    <div class="flex-1">

        {{-- 🧑‍💼 Header Selamat Datang --}}
        <div class="bg-white rounded-lg shadow p-6 text-center mb-6">
            <h2 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">
                Selamat Datang, <span class="text-blue-600">{{ Auth::user()->name }}</span>
            </h2>
            <p class="text-gray-500 text-sm sm:text-base">
                Kelola auditor dan seluruh kegiatan audit 5S dengan sistem yang terpusat.
            </p>
            <p class="text-xs italic text-gray-400 mt-2">"Audit yang baik dimulai dari data yang akurat."</p>
        </div>

        {{-- 📊 Statistik Panel --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            {{-- Total Auditor --}}
            <div class="bg-blue-100 text-blue-800 p-6 rounded-lg shadow flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium">Total Auditor</p>
                    <p class="text-3xl font-bold">{{ $totalAuditor }}</p>
                </div>
                <i data-lucide="users" class="w-10 h-10"></i>
            </div>

            {{-- Audit Selesai --}}
            <div class="bg-green-100 text-green-800 p-6 rounded-lg shadow flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium">Audit Selesai</p>
                    <p class="text-3xl font-bold">{{ $auditSelesai }}</p>
                </div>
                <i data-lucide="check-circle" class="w-10 h-10"></i>
            </div>

            {{-- Audit Dalam Proses --}}
            <div class="bg-yellow-100 text-yellow-800 p-6 rounded-lg shadow flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium">Audit Dalam Proses</p>
                    <p class="text-3xl font-bold">{{ $auditProses }}</p>
                </div>
                <i data-lucide="loader" class="w-10 h-10 animate-spin"></i>
            </div>

            {{-- Total Audit (All) --}}
            <div class="bg-purple-100 text-purple-800 p-6 rounded-lg shadow flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium">Total Audit (All)</p>
                    <p class="text-3xl font-bold">{{ $totalAuditAll }}</p>
                </div>
                <i data-lucide="file-text" class="w-10 h-10"></i>
            </div>
        </div>

        {{-- 📉 Bagian dengan Temuan Paling Sedikit --}}
        <div class="bg-white p-6 rounded-xl shadow mb-10">
            <div class="flex items-center mb-4">
                <i data-lucide="bar-chart-2" class="w-6 h-6 text-green-600 mr-2"></i>
                <h4 class="text-lg font-semibold text-gray-700">
                    Bagian dengan Temuan Paling Sedikit
                </h4>
            </div>
            <p class="text-sm text-gray-500 mb-4">
                Menampilkan bagian dengan jumlah temuan audit paling sedikit di bulan 
                <strong>{{ \Carbon\Carbon::parse(now())->translatedFormat('F') }}</strong>.
            </p>

            @if (!empty($bagianPalingSedikit) && count($bagianPalingSedikit) > 0)
                <ul class="divide-y divide-gray-200">
                    @foreach ($bagianPalingSedikit as $bagian)
                        <li class="py-3 flex justify-between items-center">
                            <div class="text-gray-700 font-medium">
                                {{ $bagian->nama_bagian }}
                            </div>
                            <span class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full font-semibold">
                                {{ $bagian->jumlah_temuan }} temuan
                            </span>
                        </li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500 italic">Belum ada data audit untuk bulan ini.</p>
            @endif
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
    lucide.createIcons();
</script>
@endpush
