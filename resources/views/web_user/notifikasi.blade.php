@extends('web_user.layouts.app')
@section('title', 'Notifikasi')

@section('content')
<div class="bg-white shadow rounded-lg p-4 w-full max-w-4xl mx-auto">

    {{-- Judul Halaman --}}
    <h2 class="text-lg font-semibold text-gray-800">Notifikasi</h2>
    <p class="text-sm text-gray-500 mb-4">Pesan masuk & pemberitahuan sistem audit</p>

    {{-- Garis pemisah --}}
    <div class="border-t border-dashed border-gray-300 my-4"></div>

    {{-- Search box --}}
    <div class="mb-4">
        <input type="text" id="searchInput" placeholder="Cari notifikasi..."
            class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:border-blue-500 focus:ring focus:ring-blue-200">
    </div>

    {{-- List Notifikasi --}}
    <div id="notifList" class="space-y-3">
        @forelse($notifikasi as $item)
            @php $isUnread = is_null($item->read_at); @endphp
            <a href="{{ route('notifikasi.show', $item->id) }}"
               class="block px-4 py-3 rounded-md border border-gray-300 transition
                      {{ $isUnread ? 'bg-blue-50 hover:bg-blue-100' : 'bg-white hover:bg-gray-50' }}">
                <div class="flex items-center gap-2">
                    <span class="text-pink-500 flex-shrink-0">📢</span>
                    <div class="flex-1 overflow-hidden">
                        <p class="font-medium text-gray-800 text-sm truncate">
                            {{ $item->data['judul'] ?? 'Notifikasi' }}
                        </p>
                        <p class="text-xs text-gray-500 truncate">
                            {{ $item->data['isi_pesan'] ?? '-' }}
                        </p>
                    </div>
                    @if($isUnread)
                        <span class="ml-2 inline-block bg-blue-600 text-white text-[10px] px-1.5 py-0.5 rounded">Baru</span>
                    @endif
                </div>
                <p class="text-[10px] text-gray-400 mt-1">
                    {{ \Carbon\Carbon::parse($item->created_at)->diffForHumans() }}
                </p>
            </a>
        @empty
            <p class="text-gray-500 text-sm">Tidak ada notifikasi.</p>
        @endforelse
    </div>
</div>

{{-- Script Pencarian --}}
<script>
document.getElementById('searchInput').addEventListener('input', function() {
    const keyword = this.value.toLowerCase();
    document.querySelectorAll('#notifList a').forEach(item => {
        const text = item.innerText.toLowerCase();
        item.style.display = text.includes(keyword) ? '' : 'none';
    });
});
</script>
@endsection
