@extends('admin.layouts.app')
@section('title', 'Manajemen Notifikasi')
@section('header', 'Manajemen Notifikasi')

@section('content')

{{-- Flash message --}}
@if(session('success'))
    <div x-data="{ show: true }" x-show="show"
         x-init="setTimeout(() => show = false, 3000)"
         class="max-w-6xl mx-auto mb-4 bg-green-100 border border-green-300 text-green-800 text-sm rounded p-3 flex justify-between items-center">
        <span>{{ session('success') }}</span>
        <button @click="show = false" class="text-green-800 hover:text-green-900 text-lg leading-none">×</button>
    </div>
@endif

@if(session('error'))
    <div x-data="{ show: true }" x-show="show"
         x-init="setTimeout(() => show = false, 3000)"
         class="max-w-6xl mx-auto mb-4 bg-red-100 border border-red-300 text-red-800 text-sm rounded p-3 flex justify-between items-center">
        <span>{{ session('error') }}</span>
        <button @click="show = false" class="text-red-800 hover:text-red-900 text-lg leading-none">×</button>
    </div>
@endif

<div x-data="notifikasiForm" class="p-4">

    {{-- Header --}}
    <div class="bg-white shadow rounded-lg p-4 w-full max-w-6xl mx-auto mb-6">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-gray-800">Manajemen Notifikasi</h2>
            <button @click="showModal = true"
                    class="bg-blue-600 text-white text-sm px-4 py-2 rounded hover:bg-blue-700 transition">
                + Kirim Notifikasi
            </button>
        </div>
    </div>

    {{-- Search --}}
    <div class="max-w-6xl mx-auto mb-4">
        <input type="text" id="searchInput" placeholder="Cari notifikasi..."
            class="w-full border-gray-300 rounded px-3 py-2 text-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
    </div>

    {{-- Riwayat Notifikasi --}}
    <div class="bg-white shadow rounded-lg p-4 w-full max-w-6xl mx-auto">
        <h3 class="text-md font-semibold text-gray-700 mb-3">Riwayat Kirim Notifikasi</h3>
        <div id="notifList" class="space-y-3">
            @forelse($notifikasi as $item)
                <a href="{{ route('admin.notifikasi.show', $item->id) }}"
                   class="block bg-white shadow-sm rounded-md px-4 py-3 hover:bg-gray-50 transition">
                    <div class="flex items-center gap-2">
                        <span class="text-pink-500 flex-shrink-0">📢</span>
                        <div class="flex-1 overflow-hidden">
                            <p class="font-medium text-gray-800 text-sm truncate">
                                {{ $item->data['judul'] ?? 'Notifikasi' }}
                            </p>
                            <p class="text-xs text-gray-500 line-clamp-2">
                                {{ $item->data['isi_pesan'] ?? '-' }}
                            </p>
                        </div>
                    </div>
                    <p class="text-[10px] text-gray-400 mt-1">
                        {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                    </p>
                </a>
            @empty
                <p class="text-gray-500 text-sm">Belum ada notifikasi yang dikirim.</p>
            @endforelse
        </div>
    </div>

    {{-- Modal --}}
    <div x-show="showModal"
         class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-50"
         x-transition>
        <div @click.away="showModal = false"
             class="bg-white w-full max-w-lg rounded-md shadow p-6 relative">

            {{-- Close --}}
            <button @click="showModal = false"
                    class="absolute top-2 right-2 text-gray-500 hover:text-gray-700">✕</button>

            <h3 class="text-xl font-semibold text-blue-700 border-b pb-2 mb-4">📢 Kirim Notifikasi</h3>

            <form method="POST" action="{{ route('admin.notifikasi.kirim') }}" enctype="multipart/form-data">
                @csrf

                {{-- Mode Penerima --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">Kirim ke:</label>
                    <label class="inline-flex items-center mr-4">
                        <input type="radio" name="mode" value="semua" x-model="mode" class="mr-2"> Semua User
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" name="mode" value="beberapa" x-model="mode" class="mr-2"> Beberapa User
                    </label>
                </div>

                {{-- Email --}}
                <template x-if="mode === 'beberapa'">
                    <div class="mb-4">
                        <label class="block font-medium mb-1">Email User (maks. 3)</label>
                        <template x-for="i in 3" :key="i">
                            <input type="email" name="emails[]" placeholder="contoh@gmail.com"
                                class="w-full border rounded p-2 mb-2 focus:ring focus:ring-blue-200">
                        </template>
                    </div>
                </template>

                {{-- Subjek --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">Subjek Pesan</label>
                    <select name="selected_subject" x-model="selectedSubject"
                            @change="isiPesan = subjects[selectedSubject]"
                            class="w-full border rounded p-2 focus:ring focus:ring-blue-200">
                        <option value="">-- Pilih Subjek --</option>
                        <option value="audit">Jadwal Audit</option>
                        <option value="verifikasi">Jadwal Verifikasi</option>
                        <option value="umum">Pemberitahuan Umum</option>
                    </select>
                </div>

                {{-- Isi Pesan --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">Isi Pesan</label>
                    <textarea name="isi_pesan" x-model="isiPesan" rows="5"
                        class="w-full border rounded p-2 focus:ring focus:ring-blue-200"
                        placeholder="Tulis pesan..."></textarea>
                </div>

                {{-- Foto --}}
                <div class="mb-4">
                    <label class="block font-medium mb-1">Lampirkan Foto (opsional)</label>
                    <input type="file" name="foto" class="w-full border rounded p-2">
                    <p class="text-gray-500 text-xs mt-1">* Kosongkan jika tidak ada lampiran.</p>
                </div>

                <div class="text-right">
                    <button type="submit"
                            class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                        Kirim Notifikasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Style Clamp (kalau Tailwind tidak support) --}}
<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>

{{-- Search --}}
<script>
document.getElementById('searchInput').addEventListener('input', function () {
    const keyword = this.value.toLowerCase();
    document.querySelectorAll('#notifList a').forEach(item => {
        const text = item.innerText.toLowerCase();
        item.style.display = text.includes(keyword) ? '' : 'none';
    });
});
</script>

{{-- Alpine --}}
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('notifikasiForm', () => ({
        mode: 'semua',
        showModal: false,
        selectedSubject: '',
        isiPesan: '',
        subjects: {
            audit: `📢 Pemberitahuan Audit 5S

Yth. Bapak/Ibu Auditor,

Audit 5S akan dilaksanakan pada tanggal : [TANGGAL_AUDIT].
Tema audit bulan ini adalah : [TEMA_AUDIT]

Mohon mempersiapkan dokumen pendukung dan memastikan area terkait dalam kondisi sesuai standar.

Terima kasih atas kerja sama dan partisipasinya.

Salam hormat,
Tim Audit 5S`,

            verifikasi: `📢 Pemberitahuan Verifikasi Audit

Yth. Bapak/Ibu Auditor,

Verifikasi hasil audit akan dilakukan pada: [TANGGAL_VERIFIKASI].

Dimohon memeriksa kembali kelengkapan data dan dokumen pendukung.

Terima kasih.

Hormat kami,
Tim Audit 5S`,

            umum: `📢 Pemberitahuan Umum

Yth. Bapak/Ibu Auditor,

Berikut informasi penting: [ISI_PESAN].

Mohon diperhatikan dan dilaksanakan sesuai instruksi.

Terima kasih.

Salam hormat,
Manajemen Audit`
        }
    }))
})
</script>
@endsection
