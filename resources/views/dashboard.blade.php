@extends('layouts.app')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Statistik Audit</h2>
            <p class="text-gray-500 text-sm">Belum ada data ditampilkan.</p>
        </div>
        <div class="bg-white rounded-xl shadow p-6">
            <h2 class="text-lg font-semibold text-gray-700 mb-2">Riwayat Audit</h2>
            <p class="text-gray-500 text-sm">Belum ada data audit.</p>
        </div>
    </div>
@endsection

@php
    $title = 'Dashboard Auditor | E-Audit Systems';
    $header = 'Selamat Datang, Auditor';
    $subheader = 'Ini adalah halaman dashboard Anda.';
@endphp
