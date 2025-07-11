@extends('web_user.layouts.app')
@section('title', 'Laporan Audit')

@section('content')
<div class="p-4">
    <h1 class="text-2xl font-bold text-gray-800 mb-2 border-b pb-1">Laporan Audit</h1>

    <!-- FILTER -->
    <form method="GET" class="bg-white p-4 rounded-lg shadow mb-6">
        <div class="grid grid-cols-1 md:grid-cols-6 gap-4">
            <input type="date" name="tanggal_awal" value="{{ request('tanggal_awal') }}" class="p-2 border rounded" placeholder="Dari">
            <input type="date" name="tanggal_akhir" value="{{ request('tanggal_akhir') }}" class="p-2 border rounded" placeholder="Sampai">

            <select name="bagian_id" class="p-2 border rounded">
                <option value="">-- Semua Bagian --</option>
                @foreach ($bagians as $bagian)
                    <option value="{{ $bagian->id }}" {{ request('bagian_id') == $bagian->id ? 'selected' : '' }}>
                        {{ $bagian->nama_bagian }}
                    </option>
                @endforeach
            </select>

            <select name="kategori" class="p-2 border rounded">
                <option value="">-- Semua Kategori --</option>
                <option value="5S" {{ request('kategori') == '5S' ? 'selected' : '' }}>5S</option>
                <option value="K3" {{ request('kategori') == 'K3' ? 'selected' : '' }}>K3</option>
            </select>

            <select name="status" class="p-2 border rounded">
                <option value="">-- Semua Status --</option>
                <option value="Open" {{ request('status') == 'Open' ? 'selected' : '' }}>Open</option>
                <option value="Close" {{ request('status') == 'Close' ? 'selected' : '' }}>Close</option>
            </select>

            <button type="submit" class="bg-blue-600 text-white py-2 px-4 rounded hover:bg-blue-700 transition">Filter</button>
        </div>
    </form>

    <!-- CHART -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white p-4 rounded shadow"><canvas id="barChart"></canvas></div>
        <div class="bg-white p-4 rounded shadow"><canvas id="pieChart"></canvas></div>
        <div class="bg-white p-4 rounded shadow"><canvas id="lineChart"></canvas></div>
    </div>

    <!-- TABEL -->
    <div class="bg-white p-4 rounded shadow mb-6 overflow-x-auto">
        <table class="min-w-full text-sm text-center border">
            <thead class="bg-gray-100 text-gray-700 font-semibold">
                <tr>
                    <th class="p-2 border">No</th>
                    <th class="p-2 border">Tema Audit</th>
                    <th class="p-2 border">Bagian</th>
                    <th class="p-2 border">Tanggal</th>
                    <th class="p-2 border">Status</th>
                    <th class="p-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($audits as $i => $a)
                    <tr class="hover:bg-gray-50">
                        <td class="p-2 border">{{ $i + 1 }}</td>
                        <td class="p-2 border">{{ $a->tema }}</td>
                        <td class="p-2 border">{{ $a->bagian->nama_bagian ?? '-' }}</td>
                        <td class="p-2 border">{{ \Carbon\Carbon::parse($a->tanggal_audit)->format('d M Y') }}</td>
                        <td class="p-2 border">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $a->status == 'Close' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-800' }}">
                                {{ $a->status }}
                            </span>
                        </td>
                        <td class="p-2 border">
                            <a href="{{ route('audit.hasil.show', $a->id) }}" class="text-blue-600 hover:underline text-sm">🔍 Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center text-gray-500 py-4 italic">Data tidak ditemukan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- EXPORT BUTTONS -->
    <div class="flex flex-wrap gap-2">
        <button onclick="window.print()" class="bg-gray-700 text-white px-4 py-2 rounded hover:bg-gray-800">🖨️ Cetak</button>
        <a href="#" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">📄 Ekspor Excel</a>
        <a href="#" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">📑 Ekspor PDF</a>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Bar Chart
    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: {!! json_encode(array_keys($auditPerBulan->toArray())) !!},
            datasets: [{
                label: 'Jumlah Audit per Bulan',
                data: {!! json_encode(array_values($auditPerBulan->toArray())) !!},
                backgroundColor: '#3B82F6'
            }]
        }
    });

    // Pie Chart
    new Chart(document.getElementById('pieChart'), {
        type: 'pie',
        data: {
            labels: {!! json_encode($auditPerBagian->pluck('nama_bagian')->toArray()) !!},
            datasets: [{
                data: {!! json_encode($auditPerBagian->pluck('total')->toArray()) !!},
                backgroundColor: ['#f87171','#34d399','#60a5fa','#fbbf24','#a78bfa']
            }]
        }
    });

    // Line Chart
    new Chart(document.getElementById('lineChart'), {
        type: 'line',
        data: {
            labels: {!! json_encode($auditTimeline->keys()) !!},
            datasets: [{
                label: 'Progres Audit',
                data: {!! json_encode($auditTimeline->values()) !!},
                borderColor: '#10B981',
                backgroundColor: 'rgba(16,185,129,0.1)',
                tension: 0.4,
                fill: true
            }]
        }
    });
</script>
@endpush
