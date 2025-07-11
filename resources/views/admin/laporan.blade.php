@extends('admin.layouts.app')

@section('title', 'Laporan Audit')

@section('content')


    {{-- 🔍 Filter --}}
    <div class="bg-white p-4 rounded-lg shadow mb-6">
        <h2 class="text-base font-semibold text-gray-700 mb-3">Filter Laporan Audit</h2>
        <form method="GET">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div>
                    <label class="text-sm font-medium text-gray-700">Bulan Audit</label>
                    <input type="month" name="bulan_audit" value="{{ request('bulan_audit', $bulanAudit) }}" class="w-full mt-1 border-gray-300 rounded shadow-sm">
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Bulan Verifikasi</label>
                    <input type="month" name="bulan_verifikasi" value="{{ request('bulan_verifikasi', $bulanVerifikasi) }}" class="w-full mt-1 border-gray-300 rounded shadow-sm">
                </div>
                <div>
                    <label class="text-sm font-medium text-gray-700">Bagian</label>
                    <select name="bagian" class="w-full mt-1 border-gray-300 rounded shadow-sm">
                        <option value="">Semua</option>
                        @foreach ($allBagian as $b)
                            <option value="{{ $b->nama_bagian }}" {{ request('bagian') == $b->nama_bagian ? 'selected' : '' }}>
                                {{ $b->nama_bagian }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="flex items-end justify-end gap-2">
                    <button type="submit" class="bg-blue-600 text-white px-3 py-1.5 text-sm rounded shadow hover:bg-blue-700">
                        Terapkan
                    </button>
                    <a href="{{ route('admin.laporan') }}" class="bg-gray-300 text-gray-700 px-3 py-1.5 text-sm rounded shadow hover:bg-gray-400">
                        Reset
                    </a>
                </div>
            </div>
        </form>
    </div>

    {{-- 🧾 Bagian Temuan Paling Sedikit --}}
    <div class="bg-gradient-to-r from-green-100 to-green-50 border-l-4 border-green-600 p-4 rounded-lg shadow mb-6">
        <div class="flex items-center">
            <svg class="w-6 h-6 text-green-600 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round"
                d="M9 17v-6a2 2 0 012-2h6"></path></svg>
            @if ($leastFindingsBagian)
                <p class="text-sm text-gray-700">
                    <strong>{{ $leastFindingsBagian['nama'] }}</strong> hanya memiliki <strong>{{ $leastFindingsBagian['jumlah'] }}</strong> temuan pada periode ini.
                </p>
            @else
                <p class="text-sm text-gray-500">Data tidak tersedia.</p>
            @endif
        </div>
    </div>

    {{-- 📊 Grafik --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-white p-4 rounded-lg shadow">
            <h2 class="font-semibold text-gray-700 mb-2">Grafik Jumlah Audit per Bagian</h2>
            <canvas id="barChart"></canvas>
        </div>
        <div class="bg-white p-4 rounded-lg shadow">
            <h2 class="font-semibold text-gray-700 mb-2">Persentase Audit per Bagian</h2>
            <canvas id="pieChart"></canvas>
        </div>
    </div>

    {{-- 📋 Tabel Rekap Audit --}}
    <div class="bg-white p-4 rounded-lg shadow">
        <h2 class="font-semibold text-gray-700 mb-4">Tabel Rekap Audit</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full border text-sm border-gray-300">
                <thead class="bg-gray-100 text-center">
                    <tr>
                        <th class="px-4 py-2 border">No</th>
                        <th class="px-4 py-2 border">Tanggal Audit</th>
                        <th class="px-4 py-2 border">Auditor</th>
                        <th class="px-4 py-2 border">Bagian</th>
                        <th class="px-4 py-2 border">Tema</th>
                        <th class="px-4 py-2 border">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($audits as $index => $audit)
                        <tr class="text-left">
                            <td class="px-4 py-2 border text-center">{{ $index + 1 }}</td>
                            <td class="px-4 py-2 border">{{ \Carbon\Carbon::parse($audit->tanggal_audit)->format('d/m/Y') }}</td>
                            <td class="px-4 py-2 border">{{ $audit->user->name }}</td>
                            <td class="px-4 py-2 border">{{ $audit->bagian->nama_bagian ?? '-' }}</td>
                            <td class="px-4 py-2 border">{{ $audit->tema }}</td>
                            <td class="px-4 py-2 border text-center">
                                @if ($audit->status === 'Close')
                                    <span class="bg-green-100 text-green-700 text-xs font-bold px-2 py-1 rounded-full">Close</span>
                                @else
                                    <span class="bg-yellow-100 text-yellow-700 text-xs font-bold px-2 py-1 rounded-full">Open</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-2 border text-center text-gray-500">Data tidak ditemukan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- 📈 Chart.js --}}
    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const barChart = new Chart(document.getElementById('barChart'), {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($barData->toArray())) !!},
                datasets: [{
                    label: 'Jumlah Audit',
                    backgroundColor: '#3B82F6',
                    data: {!! json_encode(array_values($barData->toArray())) !!}
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            label: ctx => `${ctx.label}: ${ctx.raw} audit`
                        }
                    }
                },
                scales: {
                    x: { title: { display: true, text: 'Bagian' } },
                    y: {
                        title: { display: true, text: 'Jumlah Audit' },
                        beginAtZero: true,
                        ticks: { precision: 0 }
                    }
                }
            }
        });

        const pieChart = new Chart(document.getElementById('pieChart'), {
            type: 'pie',
            data: {
                labels: {!! json_encode(array_keys($pieData->toArray())) !!},
                datasets: [{
                    backgroundColor: ['#10B981', '#F59E0B', '#3B82F6', '#EF4444', '#8B5CF6'],
                    data: {!! json_encode(array_values($pieData->toArray())) !!}
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            label: ctx => `${ctx.label}: ${ctx.raw} audit`
                        }
                    }
                }
            }
        });
    </script>
    @endpush
@endsection
