@extends('web_user.layouts.app')
@section('title', 'Riwayat Audit-ku')

@section('content')
<div class="p-4">
    <!-- Judul -->
    <div class="bg-white shadow rounded-lg p-4 w-full max-w-6xl mb-6">
        <h2 class="text-lg font-semibold text-gray-800">Riwayat Audit-ku</h2>
    </div>

    <!-- Konten Tabel -->
    <div class="bg-white shadow rounded-lg p-4 w-full max-w-6xl">
        <h3 class="text-md font-semibold text-gray-700 mb-2">Daftar Audit Close</h3>

        <!-- Bar Kontrol -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-2">
            <label class="text-sm text-gray-600">
                Tampilkan
                <select id="entriesPerPage" class="border border-gray-300 rounded px-2 py-1 mx-2 text-sm">
                    <option value="5">5</option>
                    <option value="10" selected>10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                </select>
                entri
            </label>
            <input type="text" id="searchInput" placeholder="Cari..." class="border border-gray-300 rounded px-3 py-1 text-sm w-full sm:w-64">
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-center border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 border">No</th>
                        <th class="p-2 border">Tema</th>
                        <th class="p-2 border">Bagian</th>
                        <th class="p-2 border">Status</th>
                        <th class="p-2 border">Bulan Audit</th>
                        <th class="p-2 border">Bulan Verifikasi</th>
                        <th class="p-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody id="auditBody">
                    @forelse ($auditSudahClose as $index => $audit)
                    <tr class="hover:bg-gray-50">
                        <td class="p-2 border">{{ $index + 1 }}</td>
                        <td class="p-2 border">{{ $audit->tema }}</td>
                        <td class="p-2 border">{{ $audit->bagian->nama_bagian ?? '-' }}</td>
                        <td class="p-2 border">
                            <span class="bg-green-100 text-green-700 text-xs font-semibold px-3 py-1 rounded-full inline-block">
                                Close
                            </span>
                        </td>
                        <td class="p-2 border">{{ \Carbon\Carbon::parse($audit->tanggal_audit)->translatedFormat('F Y') }}</td>
                        <td class="p-2 border">
                            {{ $audit->tanggal_verifikasi ? \Carbon\Carbon::parse($audit->tanggal_verifikasi)->translatedFormat('F Y') : '-' }}
                        </td>
                        <td class="p-2 border">
                            <a href="{{ route('audit.show', $audit->id) }}"
                               class="inline-flex items-center gap-1 text-xs text-white bg-green-500 hover:bg-green-600 px-3 py-1 rounded">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                Lihat Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="p-4 text-gray-500 italic">Belum ada audit yang sudah Close.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const entriesSelect = document.getElementById('entriesPerPage');
    const tableBody = document.getElementById('auditBody');
    const rows = Array.from(tableBody.querySelectorAll('tr'));

    function renderTable() {
        const search = searchInput.value.toLowerCase();
        const limit = parseInt(entriesSelect.value);
        let count = 0;

        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            if (text.includes(search)) {
                count++;
                row.style.display = count <= limit ? '' : 'none';
            } else {
                row.style.display = 'none';
            }
        });
    }

    searchInput.addEventListener('input', renderTable);
    entriesSelect.addEventListener('change', renderTable);
    renderTable();
});
</script>
@endpush
