@extends('web_user.layouts.app')
@section('title', 'Detail Audit')

@section('content')
<div class="max-w-5xl mx-auto bg-white shadow-md rounded-lg p-6">
    <h2 class="text-xl font-bold text-blue-700 mb-6 border-b pb-2">Detail Hasil Audit</h2>

    <form action="{{ route('audit.updateSesudah', $audit->id) }}" method="POST" enctype="multipart/form-data" id="verifikasiForm">
        @csrf
        @method('PATCH')

        <div class="border border-gray-200 rounded-md p-4 mb-8 bg-gray-50">
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
                    <label for="tanggal_verifikasi" class="text-sm font-medium text-gray-600">Tanggal Verifikasi</label>
                    @if ($audit->tanggal_verifikasi)
                        <div class="text-gray-800">
                            {{ \Carbon\Carbon::parse($audit->tanggal_verifikasi)->translatedFormat('d F Y') }}
                        </div>
                    @else
                        <input type="date" name="tanggal_verifikasi"
                            class="w-full border rounded px-3 py-2 text-sm mt-1 focus:ring-blue-500 focus:border-blue-500"
                            required>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6">
            <!-- Keterangan Sebelum -->
            <div>
                <label class="text-sm font-medium text-gray-600">Keterangan Sebelum</label>
                <div class="border rounded p-3 text-gray-700 bg-gray-50 min-h-[100px]">
                    {{ $audit->keterangan }}
                </div>
            </div>

            <!-- Keterangan Sesudah -->
            <div>
                <label for="keterangan_sesudah" class="text-sm font-medium text-gray-600 flex items-center gap-1">
                    Keterangan Sesudah <span class="text-red-600">*</span>
                </label>
                <textarea name="keterangan_sesudah" id="keterangan_sesudah"
                    class="w-full border rounded px-3 py-2 mt-1 focus:ring-blue-500 focus:border-blue-500"
                    rows="4"
                    required>{{ old('keterangan_sesudah', $audit->keterangan_sesudah) }}</textarea>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6 mt-6">
            <!-- Foto Sebelum -->
            <div>
                <label class="text-sm font-medium text-gray-600">Foto Sebelum</label>
                @if ($audit->foto_sebelum && file_exists(public_path('storage/' . $audit->foto_sebelum)))
                    <img src="{{ asset('storage/' . $audit->foto_sebelum) }}"
                         alt="Foto Sebelum"
                         class="mt-2 rounded border w-full object-contain max-h-72 bg-gray-100">
                @else
                    <div class="text-red-500 mt-2">Foto sebelum tidak ditemukan.</div>
                @endif
            </div>

            <!-- Foto Sesudah -->
            <div>
                <label class="text-sm font-medium text-gray-600 flex items-center gap-1">
                    Foto Sesudah <span class="text-red-600">*</span>
                </label>
                @if ($audit->foto_sesudah && file_exists(public_path('storage/' . $audit->foto_sesudah)))
                    <img src="{{ asset('storage/' . $audit->foto_sesudah) }}"
                         alt="Foto Sesudah"
                         class="mt-2 rounded border w-full object-contain max-h-72 bg-gray-100 mb-2">
                @endif
                <input type="file" name="foto_sesudah" accept="image/*"
                       class="w-full border rounded px-3 py-2 focus:ring-blue-500 focus:border-blue-500 mt-2" required>
            </div>
        </div>

        <div class="mt-8 flex justify-between">
            <a href="{{ url()->previous() }}"
               class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded shadow">
                &larr; Kembali
            </a>
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow font-semibold">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('verifikasiForm').addEventListener('submit', function(e) {
    e.preventDefault();
    if (confirm('Apakah Anda yakin ingin menyimpan?')) {
        this.submit();
    }
});
</script>
@endpush
