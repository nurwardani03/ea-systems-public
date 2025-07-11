<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Admin E-Audit')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        li:not(:last-child) { border-bottom: 1px solid #e5e7eb; }
    </style>
</head>
<body class="bg-gray-100 h-screen overflow-hidden">

@php
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Str;

    $menuGroups = [
        'dashboard' => 'Beranda',
        'audit' => 'Manajemen Audit',
        'user' => 'Manajemen User',
        'notifikasi' => 'Manajemen Notifikasi',
        'laporan' => 'Laporan',
    ];

    $path = request()->path(); // contoh: admin/notifikasi
    $activeGroup = collect($menuGroups)->first(function ($label, $key) use ($path) {
        return Str::contains($path, $key);
    }) ?? 'Halaman';
@endphp

<div class="flex h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg border-r border-gray-200 flex flex-col fixed top-0 bottom-0 z-40">
        <div class="flex flex-col items-center justify-center py-6 border-b border-gray-200">
            <div class="text-2xl font-bold bg-gradient-to-r from-blue-500 via-blue-400 to-blue-300 text-white px-4 py-2 rounded shadow">
                EA Systems
            </div>
            <div class="text-xs text-gray-400 mt-1">Easy Audit Systems</div>
            <div class="text-xs text-gray-400 mt-1">Admin</div>
        </div>

        <nav class="flex-1 overflow-y-auto">
            <ul>
                <li><a href="{{ route('admin.dashboard') }}" class="block px-6 py-3 {{ request()->is('admin/dashboard') ? 'bg-gradient-to-r from-blue-500 via-blue-400 to-blue-300 text-white font-semibold' : 'hover:bg-gradient-to-r hover:from-blue-500 hover:via-blue-400 hover:to-blue-300 hover:text-white hover:font-semibold text-gray-700' }}">Beranda</a></li>
                <li><a href="{{ route('admin.audit') }}" class="block px-6 py-3 {{ request()->is('admin/audit*') ? 'bg-gradient-to-r from-blue-500 via-blue-400 to-blue-300 text-white font-semibold' : 'hover:bg-gradient-to-r hover:from-blue-500 hover:via-blue-400 hover:to-blue-300 hover:text-white hover:font-semibold text-gray-700' }}">Manajemen Audit</a></li>
                <li><a href="{{ route('admin.user') }}" class="block px-6 py-3 {{ request()->is('admin/user*') ? 'bg-gradient-to-r from-blue-500 via-blue-400 to-blue-300 text-white font-semibold' : 'hover:bg-gradient-to-r hover:from-blue-500 hover:via-blue-400 hover:to-blue-300 hover:text-white hover:font-semibold text-gray-700' }}">Manajemen User</a></li>
                <li><a href="{{ route('admin.notifikasi') }}" class="block px-6 py-3 {{ request()->is('admin/notifikasi*') ? 'bg-gradient-to-r from-blue-500 via-blue-400 to-blue-300 text-white font-semibold' : 'hover:bg-gradient-to-r hover:from-blue-500 hover:via-blue-400 hover:to-blue-300 hover:text-white hover:font-semibold text-gray-700' }}">Manajemen Notifikasi</a></li>
                <li><a href="{{ route('admin.laporan') }}" class="block px-6 py-3 {{ request()->is('admin/laporan*') ? 'bg-gradient-to-r from-blue-500 via-blue-400 to-blue-300 text-white font-semibold' : 'hover:bg-gradient-to-r hover:from-blue-500 hover:via-blue-400 hover:to-blue-300 hover:text-white hover:font-semibold text-gray-700' }}">Laporan</a></li>
                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-left px-6 py-3 hover:bg-gradient-to-r hover:from-blue-500 hover:via-blue-400 hover:to-blue-300 hover:text-white hover:font-semibold text-gray-700">
                            Keluar
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Konten -->
    <div class="flex-1 flex flex-col ml-64">
        <!-- Header -->
        <header class="sticky top-0 z-40 bg-gradient-to-r from-blue-500 via-blue-400 to-blue-300 px-6 py-4 shadow flex justify-between items-center">
            <!-- Judul Halaman -->
            <div class="text-white font-semibold text-lg">
                {{ $activeGroup }}
            </div>

            <!-- Info User -->
            <div class="flex items-center gap-4">
                <div class="bg-white rounded-full w-9 h-9 flex items-center justify-center shadow">
                    <span class="text-blue-600 font-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                </div>
                <div class="text-white font-semibold">{{ Auth::user()->name }}</div>

                <!-- Dropdown -->
                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="text-white hover:opacity-80 focus:outline-none flex items-center">
                        <i data-lucide="chevron-down" class="w-5 h-5"></i>
                    </button>
                    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-40 bg-white rounded-md shadow-lg py-2 text-sm z-50">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-gray-100 text-gray-700">Ganti Akun</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100 text-gray-700">Keluar</button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Konten Halaman -->
        <main class="p-6 flex-1 overflow-y-auto bg-gray-100">
            @yield('content')
        </main>

    <footer class="bg-white border-t border-gray-200 text-center text-sm text-gray-600 py-4 mt-auto">
    <div class="max-w-screen-xl mx-auto px-4 sm:flex sm:justify-center sm:items-center">
        <p class="mb-2 sm:mb-0">
            &copy; {{ date('Y') }} <span class="font-semibold">Easy Audit Systems</span>
        </p>
        <span class="hidden sm:inline mx-2">|</span>
        <p class="text-gray-400 italic">
            {{ config('app.version') }}. All rights reserved.
        </p>

    </div>
    </footer>


    </div>
</div>

<script> lucide.createIcons(); </script>
@stack('scripts')
</body>
</html>
