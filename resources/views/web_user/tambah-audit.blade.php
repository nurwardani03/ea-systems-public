@extends('web_user.layouts.app')
@section('title', 'Audit-KU')

@section('content')
<div class="p-4" x-data="{ open: false }">

    <!-- Header Judul & Tombol Tambah -->
    <div class="bg-white shadow rounded-lg p-4 w-full mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800">Audit-KU</h2>
            <button @click="open = true" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow">
                + Tambah Audit
            </button>
        </div>
    </div>

    <!-- Modal Tambah Audit -->
    <div x-show="open" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" x-cloak>
        <div class="bg-white w-full max-w-2xl p-6 rounded-lg shadow-lg relative z-50">
            <h2 class="text-xl font-semibold text-blue-700 border-b pb-2 mb-4">Form Tambah Audit</h2>
            <form action="{{ route('audit.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm text-gray-700">Nama Auditor</label>
                        <input type="text" name="auditor" required class="w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="text-sm text-gray-700">Tema Audit</label>
                        <input type="text" name="tema" required class="w-full border rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="text-sm text-gray-700">Kategori Audit</label>
                        <select name="kategori" required class="w-full border rounded px-3 py-2">
                            <option value="">-- Pilih --</option>
                            <option>Ringkas</option>
                            <option>Rapi</option>
                            <option>Resik</option>
                            <option>ISO 14001</option>
                            <option>Lainnya</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-sm text-gray-700">Bagian yang di Audit</label>
                        <select name="bagian_id" required class="w-full border rounded px-3 py-2">
                            <option value="">-- Pilih Bagian --</option>
                            @foreach ($bagians as $bagian)
                                <option value="{{ $bagian->id }}">{{ $bagian->nama_bagian }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="text-sm text-gray-700">Tanggal Audit</label>
                        <input type="date" name="tanggal_audit" required class="w-full border rounded px-3 py-2">
                    </div>
                    <div class="col-span-2">
                        <label class="text-sm text-gray-700">Area Temuan</label>
                        <input type="text" name="lokasi" class="w-full border rounded px-3 py-2">
                    </div>
                    <div class="col-span-2">
                        <label class="text-sm text-gray-700">Keterangan</label>
                        <input type="text" name="keterangan" class="w-full border rounded px-3 py-2">
                    </div>
                    <div class="col-span-2">
                        <label class="text-sm text-gray-700">Foto Sebelum <span class="text-red-600">*</span></label>
                        <input type="file" name="foto_sebelum" accept="image/*" required class="w-full border rounded px-3 py-2">
                    </div>
                </div>
                <div class="mt-4 flex justify-end gap-2">
                    <button @click="open = false" type="button" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white hover:bg-blue-700 rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Tabel Verifikasi Audit -->
    <div class="bg-white shadow rounded-lg p-4 w-full">
        <h3 class="text-md font-semibold text-gray-700 mb-2">Verifikasi Audit</h3>

        <!-- Bar Kontrol Tampilkan dan Cari -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-2">
            <label class="text-sm text-gray-600">
                Tampilkan
                <select id="entriesPerPage" class="border-gray-300 border rounded px-2 py-1 mx-2 text-sm">
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
                        <th class="p-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody id="auditBody">
                    @foreach ($auditBelumClose as $index => $audit)
                    <tr class="hover:bg-gray-50">
                        <td class="p-2 border">{{ $index + 1 }}</td>
                        <td class="p-2 border">{{ $audit->tema }}</td>
                        <td class="p-2 border">{{ $audit->bagian->nama_bagian ?? '-' }}</td>
                        <td class="p-2 border">
                            <span class="bg-yellow-100 text-yellow-500 text-xs font-semibold px-3 py-1 rounded-full inline-block">
                                Open
                            </span>
                        </td>
                        <td class="p-2 border">{{ \Carbon\Carbon::parse($audit->tanggal_audit)->translatedFormat('F Y') }}</td>
                        <td class="p-2 border">
                        <a href="{{ route('audit.show', $audit->id) }}"
                            class="inline-flex items-center gap-1 text-xs text-white bg-green-500 hover:bg-green-600 px-3 py-1 rounded">
                            <!-- Icon mata -->
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
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const entriesSelect = document.getElementById("entriesPerPage");
    const searchInput = document.getElementById("searchInput");
    const tbody = document.getElementById("auditBody");
    const rows = Array.from(tbody.querySelectorAll("tr"));

    function filterTable() {
        const searchTerm = searchInput.value.toLowerCase();
        const perPage = parseInt(entriesSelect.value);
        let visibleCount = 0;

        rows.forEach((row) => {
            const rowText = row.innerText.toLowerCase();
            const matches = rowText.includes(searchTerm);
            if (matches && visibleCount < perPage) {
                row.style.display = "";
                visibleCount++;
            } else {
                row.style.display = "none";
            }
        });
    }

    entriesSelect.addEventListener("change", filterTable);
    searchInput.addEventListener("input", filterTable);
    filterTable();
});
</script>
@endpush
