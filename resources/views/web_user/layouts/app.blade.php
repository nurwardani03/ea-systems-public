<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem E-Audit')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Poppins', sans-serif; }
        li:not(:last-child) { border-bottom: 1px solid #e5e7eb; }
    </style>
</head>
<body class="bg-gray-100 h-screen overflow-hidden">

@php use Illuminate\Support\Facades\Auth; @endphp

<div class="flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-64 bg-white shadow-lg border-r border-gray-200 flex flex-col h-full sticky top-0">
        <div class="flex items-center justify-center py-6 border-b border-gray-200">
            <div class="text-center">
                <div class="text-2xl font-bold bg-gradient-to-r from-blue-500 via-blue-400 to-blue-300 text-white px-4 py-2 rounded shadow">
                    EA Systems
                </div>
                <div class="text-xs text-gray-400 mt-1">Easy Audit Systems</div>
                <div class="text-xs text-gray-400 mt-1">Auditor</div>
            </div>
        </div>

        <nav class="flex-1 overflow-y-auto">
            <ul>
                <li>
                    <a href="{{ route('dashboard') }}"
                       class="block px-6 py-3 {{ request()->is('dashboard') ? 'bg-gradient-to-r from-blue-500 via-blue-400 to-blue-300 text-white font-semibold' : 'hover:bg-gradient-to-r hover:from-blue-500 hover:via-blue-400 hover:to-blue-300 hover:text-white hover:font-semibold text-gray-700' }}">
                        Beranda
                    </a>
                </li>

                <li x-data="{ open: {{ request()->is('tambah-audit') || request()->is('riwayat-audit') || request()->is('hasil-audit') ? 'true' : 'false' }} }" class="relative">
                    <button @click="open = !open"
                            class="w-full text-left px-6 py-3 flex justify-between items-center {{ request()->is('tambah-audit') || request()->is('riwayat-audit') || request()->is('hasil-audit') ? 'bg-gradient-to-r from-blue-500 via-blue-400 to-blue-300 text-white font-semibold' : 'hover:bg-gradient-to-r hover:from-blue-500 hover:via-blue-400 hover:to-blue-300 hover:text-white hover:font-semibold text-gray-700' }}">
                        <span>Manajemen Audit</span>
                        <svg class="w-4 h-4 ml-2 transform transition-transform duration-200" :class="{ 'rotate-180': open }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </button>
                    <ul x-show="open" class="bg-white text-sm" x-transition>
                        <li><a href="{{ route('audit.create') }}"
                               class="block px-10 py-2 {{ request()->is('tambah-audit') ? 'bg-gradient-to-r from-blue-500 via-blue-400 to-blue-300 text-white font-semibold' : 'hover:bg-gradient-to-r hover:from-blue-500 hover:via-blue-400 hover:to-blue-300 hover:text-white hover:font-semibold text-gray-700' }}">
                            Audit-Ku</a></li>
                        <li><a href="{{ route('audit.riwayat') }}"
                               class="block px-10 py-2 {{ request()->is('riwayat-audit') ? 'bg-gradient-to-r from-blue-500 via-blue-400 to-blue-300 text-white font-semibold' : 'hover:bg-gradient-to-r hover:from-blue-500 hover:via-blue-400 hover:to-blue-300 hover:text-white hover:font-semibold text-gray-700' }}">
                            Riwayat Audit-Ku</a></li>
                        <li><a href="{{ route('audit.hasil') }}"
                               class="block px-10 py-2 {{ request()->is('hasil-audit') ? 'bg-gradient-to-r from-blue-500 via-blue-400 to-blue-300 text-white font-semibold' : 'hover:bg-gradient-to-r hover:from-blue-500 hover:via-blue-400 hover:to-blue-300 hover:text-white hover:font-semibold text-gray-700' }}">
                            Hasil Audit</a></li>
                    </ul>
                </li>

                <li>
                    <a href="{{ route('notifikasi.index') }}"
                       class="block px-6 py-3 {{ request()->is('notifikasi') ? 'bg-gradient-to-r from-blue-500 via-blue-400 to-blue-300 text-white font-semibold' : 'hover:bg-gradient-to-r hover:from-blue-500 hover:via-blue-400 hover:to-blue-300 hover:text-white hover:font-semibold text-gray-700' }}">
                        Notifikasi
                    </a>
                </li>

                <li>
                    <a href="{{ route('profile.edit') }}"
                       class="block px-6 py-3 {{ request()->is('profile') ? 'bg-gradient-to-r from-blue-500 via-blue-400 to-blue-300 text-white font-semibold' : 'hover:bg-gradient-to-r hover:from-blue-500 hover:via-blue-400 hover:to-blue-300 hover:text-white hover:font-semibold text-gray-700' }}">
                        Pengaturan Akun
                    </a>
                </li>

                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="block w-full text-left px-6 py-3 hover:bg-gradient-to-r hover:from-blue-500 hover:via-blue-400 hover:to-blue-300 hover:text-white hover:font-semibold text-gray-700">
                            Keluar
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </aside>

    <!-- Area Konten dan Header -->
    <div class="flex-1 flex flex-col h-full">

        <!-- Header -->
        <header class="sticky top-0 z-50 bg-gradient-to-r from-blue-500 via-blue-400 to-blue-300 px-6 py-4 shadow flex justify-between items-center">
            @php
                use Illuminate\Support\Str;
                $menuGroups = [
                    'dashboard' => 'Beranda',
                    'tambah-audit' => 'Manajemen Audit',
                    'riwayat-audit' => 'Manajemen Audit',
                    'hasil-audit' => 'Manajemen Audit',
                    'notifikasi' => 'Notifikasi',
                    'profile' => 'Pengaturan Akun',
                ];
                $path = request()->path();
                $activeGroup = collect($menuGroups)->first(fn($label, $key) => Str::contains($path, $key)) ?? 'Halaman';
            @endphp

            <div class="text-white font-semibold text-lg">
                {{ $activeGroup }}
            </div>

            <div class="flex items-center gap-4">
                <div class="bg-white rounded-full w-9 h-9 flex items-center justify-center shadow">
                    <span class="text-blue-600 font-bold">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                </div>

                <div class="text-white font-semibold">
                    {{ Auth::user()->name }}
                </div>

                <div class="relative">
                    @php
                        use Illuminate\Notifications\DatabaseNotification;
                        $notifCount = Auth::check()
                            ? DatabaseNotification::where('notifiable_id', Auth::id())->whereNull('read_at')->count()
                            : 0;
                    @endphp
                    <a href="{{ route('notifikasi.index') }}" class="text-white hover:opacity-80 focus:outline-none">
                        <i data-lucide="bell" class="w-5 h-5"></i>
                        @if ($notifCount > 0)
                            <span class="absolute top-0 right-0 inline-flex items-center justify-center w-4 h-4 bg-red-500 text-white rounded-full text-xs">
                                {{ $notifCount }}
                            </span>
                        @endif
                    </a>
                </div>

                <div x-data="{ open: false }" class="relative">
                    <button @click="open = !open" class="text-white hover:opacity-80 focus:outline-none flex items-center">
                        <i data-lucide="chevron-down" class="w-5 h-5"></i>
                    </button>
                    <div x-show="open" @click.away="open = false"
                         class="absolute right-0 mt-2 w-40 bg-white rounded-md shadow-lg py-2 text-sm z-50">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 hover:bg-gray-100 text-gray-700">Ganti Akun</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 hover:bg-gray-100 text-gray-700">Keluar</button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Konten -->
        <main class="flex-1 overflow-y-auto bg-gray-100">
            <div class="p-6">
                @yield('content')
            </div>
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
