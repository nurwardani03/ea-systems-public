@php
    $idEntries = "entries" . ucfirst($tableId);
    $idSearch = "search" . ucfirst($tableId);
    $idBody = $tableId . "Body";
@endphp

{{-- 🔎 Filter & Search --}}
<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-2">
    <label class="text-sm text-gray-600">
        Tampilkan
        <select id="{{ $idEntries }}" class="border-gray-300 border rounded px-2 py-1 mx-2 text-sm">
            <option value="5">5</option>
            <option value="10" selected>10</option>
            <option value="25">25</option>
            <option value="50">50</option>
        </select> entri
    </label>
    <input type="text" id="{{ $idSearch }}" placeholder="Cari {{ $title }}..." class="border border-gray-300 rounded px-3 py-1 text-sm w-full sm:w-64">
</div>

{{-- 📋 Tabel --}}
<div class="overflow-x-auto">
    <table class="w-full text-sm text-center border border-gray-200">
        <thead class="bg-gray-100">
            <tr>
                <th class="p-2 border">No</th>
                <th class="p-2 border">Tema</th>
                <th class="p-2 border">Bagian</th>
                <th class="p-2 border">Tanggal Audit</th>
                <th class="p-2 border">Tanggal Verifikasi</th>
                <th class="p-2 border">Status</th>
                <th class="p-2 border">Aksi</th>
            </tr>
        </thead>
        <tbody id="{{ $idBody }}">
            @forelse ($audits as $i => $audit)
                <tr class="hover:bg-gray-50">
                    <td class="p-2 border">{{ $i + 1 }}</td>
                    <td class="p-2 border">{{ $audit->tema }}</td>
                    <td class="p-2 border">{{ $audit->bagian->nama_bagian ?? '-' }}</td>
                    <td class="p-2 border">{{ \Carbon\Carbon::parse($audit->tanggal_audit)->format('d-m-Y') }}</td>
                    <td class="p-2 border">
                        @if ($audit->tanggal_verifikasi)
                            {{ \Carbon\Carbon::parse($audit->tanggal_verifikasi)->format('d-m-Y') }}
                        @else
                            <span class="text-gray-400 italic">Belum diverifikasi</span>
                        @endif
                    </td>
                    <td class="p-2 border">
                        <span class="{{ strtolower($audit->status) === 'close' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }} text-xs font-semibold px-3 py-1 rounded-full">
                            {{ ucfirst($audit->status ?? 'Open') }}
                        </span>
                    </td>
                    <td class="p-2 border">
                        <a href="{{ route('admin.audit.detail', $audit->id) }}" class="bg-green-500 text-white text-xs px-3 py-1 rounded hover:bg-green-600">
                            👁 Detail
                        </a>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="p-4 italic text-gray-500">Belum ada data.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
