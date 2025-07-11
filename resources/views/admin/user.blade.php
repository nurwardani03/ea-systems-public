@extends('admin.layouts.app')

@section('title', 'Manajemen User')
@section('header', 'Manajemen User')

@php
    use Illuminate\Support\Js;
@endphp

@section('content')
<div class="p-4" x-data="{
    open: false,
    editOpen: false,
    deleteConfirm: false,
    selectedUser: null,
    deleteUrl: ''
}">
    <!-- Header Judul & Tombol Tambah -->
    <div class="bg-white shadow rounded-lg p-4 w-full mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800">Manajemen User</h2>
            <button @click="open = true" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow text-sm">
                + Tambah User
            </button>
        </div>
    </div>

    <!-- Modal Tambah User -->
    <div x-show="open" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" x-cloak>
        <div class="bg-white w-full max-w-lg p-6 rounded-lg shadow-lg relative z-50">
            <h2 class="text-xl font-semibold text-blue-700 border-b pb-2 mb-4">Tambah User Baru</h2>
            <form action="{{ route('admin.user.store') }}" method="POST">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="text-sm text-gray-700">Nama</label>
                        <input type="text" name="name" required class="w-full border rounded px-3 py-2">
                        @error('name')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-span-2">
                        <label class="text-sm text-gray-700">Email</label>
                        <input type="email" name="email" required class="w-full border rounded px-3 py-2">
                        @error('email')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
                    </div>
                    <div class="col-span-2">
                        <label class="text-sm text-gray-700">Bagian</label>
                        <select name="bagian_id" required class="w-full border rounded px-3 py-2">
                            <option value="">-- Pilih Bagian --</option>
                            @foreach ($bagians as $bagian)
                                <option value="{{ $bagian->id }}">{{ $bagian->nama_bagian }}</option>
                            @endforeach
                        </select>
                        @error('bagian_id')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
                    </div>
                    <div>
                        <label class="text-sm text-gray-700">Password</label>
                        <input type="password" name="password" required class="w-full border rounded px-3 py-2">
                        @error('password')<span class="text-red-600 text-xs">{{ $message }}</span>@enderror
                    </div>
                    <div>
                        <label class="text-sm text-gray-700">Ulangi Password</label>
                        <input type="password" name="password_confirmation" required class="w-full border rounded px-3 py-2">
                    </div>
                </div>
                <div class="mt-4 flex justify-end gap-2">
                    <button @click="open = false" type="button" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white hover:bg-blue-700 rounded">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Edit User -->
    <div x-show="editOpen && selectedUser" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" x-cloak>
        <div class="bg-white w-full max-w-lg p-6 rounded-lg shadow-lg relative z-50">
            <h2 class="text-xl font-semibold text-blue-700 border-b pb-2 mb-4">Edit User</h2>
            <form :action="`/admin/user/${selectedUser.id}`" method="POST">
                @csrf
                @method('PUT')
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <label class="text-sm text-gray-700">Nama</label>
                        <input type="text" :value="selectedUser.name" disabled class="w-full border rounded px-3 py-2 bg-gray-100">
                    </div>
                    <div class="col-span-2">
                        <label class="text-sm text-gray-700">Email</label>
                        <input type="email" :value="selectedUser.email" disabled class="w-full border rounded px-3 py-2 bg-gray-100">
                    </div>
                    <div class="col-span-2">
                        <label class="text-sm text-gray-700">Bagian</label>
                        <select name="bagian_id" required class="w-full border rounded px-3 py-2">
                            <template x-for="bagian in {{ Js::from($bagians) }}" :key="bagian.id">
                                <option :value="bagian.id" x-text="bagian.nama_bagian" :selected="bagian.id === selectedUser.bagian_id"></option>
                            </template>
                        </select>
                    </div>
                    <div class="col-span-2">
                        <label class="text-sm text-gray-700">Password Baru <span class="text-xs text-gray-400">(opsional)</span></label>
                        <input type="password" name="password" class="w-full border rounded px-3 py-2" placeholder="Kosongkan jika tidak ingin ubah">
                    </div>
                    <div class="col-span-2">
                        <label class="text-sm text-gray-700">Ulangi Password</label>
                        <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2">
                    </div>
                </div>
                <div class="mt-4 flex justify-end gap-2">
                    <button @click="editOpen = false" type="button" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white hover:bg-blue-700 rounded">Update</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Modal Konfirmasi Hapus -->
    <div x-show="deleteConfirm" class="fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center" x-cloak>
        <div class="bg-white rounded-lg shadow-lg p-6 max-w-sm w-full">
            <h3 class="text-lg font-semibold text-gray-800 mb-4">Konfirmasi Hapus</h3>
            <p class="text-sm text-gray-600 mb-4">Apakah Anda yakin ingin menghapus user ini?</p>
            <div class="flex justify-end gap-2">
                <button @click="deleteConfirm = false" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 rounded">Batal</button>
                <form :action="deleteUrl" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="px-4 py-2 bg-red-600 text-white hover:bg-red-700 rounded">Hapus</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Tabel User -->
    <div class="bg-white shadow rounded-lg p-4 w-full">
        <h3 class="text-md font-semibold text-gray-700 mb-2">Daftar Auditor</h3>

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
            <input type="text" id="searchInput" placeholder="Cari user..." class="border border-gray-300 rounded px-3 py-1 text-sm w-full sm:w-64">
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-sm text-center border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-2 border">No</th>
                        <th class="p-2 border">Nama</th>
                        <th class="p-2 border">Email</th>
                        <th class="p-2 border">Bagian</th>
                        <th class="p-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody id="userTableBody">
                    @forelse ($users as $index => $user)
                        <tr class="hover:bg-gray-50">
                            <td class="p-2 border">{{ $index + 1 }}</td>
                            <td class="p-2 border">{{ $user->name }}</td>
                            <td class="p-2 border">{{ $user->email }}</td>
                            <td class="p-2 border">{{ $user->bagian->nama_bagian ?? '-' }}</td>
                            <td class="p-2 border space-x-2 flex justify-center">
                                <button @click="selectedUser = {{ Js::from($user) }}, editOpen = true" class="text-blue-600 hover:text-blue-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M16.5 3.5a2.121 2.121 0 113 3L12 14l-4 1 1-4 7.5-7.5z" />
                                    </svg>
                                </button>
                                <button @click="deleteConfirm = true; deleteUrl = '/admin/user/{{ $user->id }}'" class="text-red-600 hover:text-red-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7h6m2 0a2 2 0 00-2-2H9a2 2 0 00-2 2h10z" />
                                    </svg>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-4 text-gray-500">Belum ada auditor terdaftar.</td>
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
document.addEventListener("DOMContentLoaded", function () {
    const entriesSelect = document.getElementById("entriesPerPage");
    const searchInput = document.getElementById("searchInput");
    const tbody = document.getElementById("userTableBody");
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
