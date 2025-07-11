@extends('admin.layouts.app')
@section('title', 'Manajemen Audit')

@section('content')
@php
    use Carbon\Carbon;
    $now = Carbon::now();
@endphp

<div class="p-4">

    {{-- 🔵 Informasi Periode --}}
    @if ($isBulanAudit)
        <div class="bg-blue-50 border border-blue-200 text-blue-800 p-4 rounded-lg mb-6">
            <h2 class="text-lg font-semibold">Periode Audit: {{ $now->translatedFormat('F Y') }}</h2>
            <p class="text-sm">Saat ini sedang masa audit. Verifikasi akan dilakukan bulan depan.</p>
        </div>
    @else
        <div class="bg-yellow-50 border border-yellow-200 text-yellow-800 p-4 rounded-lg mb-6">
            <h2 class="text-lg font-semibold">Periode Verifikasi: {{ $now->copy()->subMonth()->translatedFormat('F Y') }}</h2>
            <p class="text-sm">Saat ini sedang masa verifikasi audit yang dilakukan bulan lalu.</p>
        </div>
    @endif

    {{-- ✅ Audit Bulan Ini --}}
    <div class="bg-white shadow rounded-lg p-6 mb-10">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Audit Bulan Ini</h3>

        @if ($auditBulanIni->whereNull('tanggal_verifikasi')->count() > 0 && $isBulanAudit)
        <div class="mb-6 bg-white border border-gray-200 rounded-lg p-4">
            <h2 class="text-md font-semibold text-gray-700 mb-2">🗓️ Tentukan Tanggal Verifikasi</h2>
            <form action="{{ route('admin.audit.setAllVerifikasi') }}" method="POST" class="flex flex-col md:flex-row items-center gap-4">
                @csrf
                <input type="hidden" name="audit_ids" value="{{ $auditBulanIni->pluck('id')->implode(',') }}">
                <input type="date" name="tanggal_verifikasi" required class="border px-2 py-1 text-sm rounded">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
                    💾 Simpan Verifikasi
                </button>
            </form>
        </div>
        @endif

        @include('admin.audit-riwayat', [
            'audits' => $auditBulanIni,
            'tableId' => 'auditMonth',
            'title' => 'audit bulan ini'
        ])
    </div>

    {{-- ✅ Verifikasi Audit --}}
    <div class="bg-white shadow rounded-lg p-6 mb-10">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Verifikasi Audit</h3>

        @if (!$isBulanAudit && $auditBulanKemarin->whereNull('tanggal_audit')->count() > 0)
        <div class="mb-6 bg-white border border-gray-200 rounded-lg p-4">
            <h2 class="text-md font-semibold text-gray-700 mb-2">🗓️ Tentukan Tanggal Audit</h2>
            <form action="{{ route('admin.audit.setAllAudit') }}" method="POST" class="flex flex-col md:flex-row items-center gap-4">
                @csrf
                <input type="hidden" name="audit_ids" value="{{ $auditBulanKemarin->pluck('id')->implode(',') }}">
                <input type="date" name="tanggal_audit" required class="border px-2 py-1 text-sm rounded">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
                    💾 Simpan Audit
                </button>
            </form>
        </div>
        @endif

        @include('admin.audit-riwayat', [
            'audits' => $auditBulanKemarin,
            'tableId' => 'verifikasi',
            'title' => 'verifikasi audit'
        ])
    </div>

    {{-- ✅ Riwayat Audit --}}
    <div class="bg-white shadow rounded-lg p-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-4">Riwayat Audit</h3>

        {{-- Filter --}}
        <div class="mb-6 bg-white border border-gray-200 rounded-lg p-4">
            <h2 class="text-md font-semibold text-gray-700 mb-4 flex items-center gap-2">
                <span class="text-blue-500">🎯</span> Filter Riwayat Audit
            </h2>
            <form method="GET" class="grid md:grid-cols-12 gap-4 items-end">
                <div class="md:col-span-3">
                    <label class="text-sm font-medium text-gray-700">Bulan Audit</label>
                    <input type="month" name="bulan_riwayat" value="{{ request('bulan_riwayat') }}" class="w-full mt-1 border-gray-300 rounded shadow-sm text-sm">
                </div>
                <div class="md:col-span-3">
                    <label class="text-sm font-medium text-gray-700">Bagian</label>
                    <select name="bagian_riwayat" class="w-full mt-1 border-gray-300 rounded shadow-sm text-sm">
                        <option value="">Semua</option>
                        @foreach ($allBagian as $b)
                            <option value="{{ $b->nama_bagian }}" {{ request('bagian_riwayat') == $b->nama_bagian ? 'selected' : '' }}>
                                {{ $b->nama_bagian }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="md:col-span-6 flex justify-end gap-3">
                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white text-sm px-4 py-2 rounded flex items-center gap-2">
                        Terapkan
                    </button>
                    <a href="{{ route('admin.audit') }}" class="bg-gray-200 hover:bg-gray-300 text-gray-800 text-sm px-4 py-2 rounded flex items-center gap-2">
                        Reset
                    </a>
                </div>
            </form>
        </div>

        @include('admin.audit-riwayat', [
            'audits' => $riwayatAudit,
            'tableId' => 'auditAll',
            'title' => 'riwayat audit'
        ])
    </div>

</div>
@endsection

@push('scripts')
<script>
function setupTableFilter(searchId, entriesId, tbodyId) {
    const searchInput = document.getElementById(searchId);
    const entriesSelect = document.getElementById(entriesId);
    const tbody = document.getElementById(tbodyId);
    const rows = Array.from(tbody.querySelectorAll("tr"));

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const perPage = parseInt(entriesSelect.value);
        let visibleCount = 0;

        rows.forEach((row) => {
            const rowText = row.innerText.toLowerCase();
            const match = rowText.includes(searchTerm);
            if (match && visibleCount < perPage) {
                row.style.display = "";
                visibleCount++;
            } else {
                row.style.display = "none";
            }
        });
    }

    searchInput.addEventListener("input", filterTable);
    entriesSelect.addEventListener("change", filterTable);
    filterTable();
}

document.addEventListener("DOMContentLoaded", function () {
    setupTableFilter("searchAuditMonth", "entriesAuditMonth", "auditMonthBody");
    setupTableFilter("searchVerifikasi", "entriesVerifikasi", "verifikasiBody");
    setupTableFilter("searchAuditAll", "entriesAuditAll", "auditAllBody");
});
</script>
@endpush
