@extends('web_user.layouts.app')
@section('title', 'Verifikasi Audit')

@section('content')
<div class="space-y-10">

    <!-- Judul Halaman -->
    <div class="text-center">
        <h1 class="text-2xl font-bold text-blue-600 border-b pb-2 inline-block">Verifikasi Audit</h1>
    </div>

    <!-- Verifikasi Bulan Ini -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Verifikasi Bulan Ini</h2>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-300 text-sm text-gray-700">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="px-4 py-2">No</th>
                        <th class="px-4 py-2">Tema Audit</th>
                        <th class="px-4 py-2">Bagian</th>
                        <th class="px-4 py-2">Tanggal</th>
                        <th class="px-4 py-2">Status</th>
                    </tr>
                    <tr class="bg-gray-50">
                        <th></th>
                        <th><input type="text" placeholder="Filter Tema" class="border p-1 rounded w-full"></th>
                        <th><input type="text" placeholder="Filter Bagian" class="border p-1 rounded w-full"></th>
                        <th><input type="text" placeholder="Filter Tanggal" class="border p-1 rounded w-full"></th>
                        <th><input type="text" placeholder="Filter Status" class="border p-1 rounded w-full"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($verifikasiBulanIni as $index => $audit)
                        <tr class="border-t">
                            <td class="px-4 py-2 text-center">{{ $index + 1 }}</td>
                            <td class="px-4 py-2">{{ $audit->tema }}</td>
                            <td class="px-4 py-2">{{ $audit->bagian }}</td>
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($audit->created_at)->format('d M Y') }}</td>
                            <td class="px-4 py-2 font-semibold text-blue-600">{{ $audit->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Semua Riwayat Audit -->
    <div class="bg-white rounded-lg shadow p-6">
        <h2 class="text-xl font-semibold text-gray-700 mb-4">Riwayat Audit</h2>

        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-300 text-sm text-gray-700">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="px-4 py-2">No</th>
                        <th class="px-4 py-2">Tema Audit</th>
                        <th class="px-4 py-2">Bagian</th>
                        <th class="px-4 py-2">Tanggal</th>
                        <th class="px-4 py-2">Status</th>
                    </tr>
                    <tr class="bg-gray-50">
                        <th></th>
                        <th><input type="text" placeholder="Filter Tema" class="border p-1 rounded w-full"></th>
                        <th><input type="text" placeholder="Filter Bagian" class="border p-1 rounded w-full"></th>
                        <th><input type="text" placeholder="Filter Tanggal" class="border p-1 rounded w-full"></th>
                        <th><input type="text" placeholder="Filter Status" class="border p-1 rounded w-full"></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($riwayatAudit as $index => $audit)
                        <tr class="border-t">
                            <td class="px-4 py-2 text-center">{{ $index + 1 }}</td>
                            <td class="px-4 py-2">{{ $audit->tema }}</td>
                            <td class="px-4 py-2">{{ $audit->bagian }}</td>
                            <td class="px-4 py-2">{{ \Carbon\Carbon::parse($audit->created_at)->format('d M Y') }}</td>
                            <td class="px-4 py-2 font-semibold {{ $audit->status == 'Belum Diverifikasi' ? 'text-red-600' : 'text-green-600' }}">{{ $audit->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
