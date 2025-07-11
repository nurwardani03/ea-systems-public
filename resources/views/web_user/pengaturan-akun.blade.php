@extends('web_user.layouts.app')
@section('title', 'Pengaturan Akun')

@section('content')
<div class="p-4 flex justify-center">
    <div class="w-full max-w-4xl space-y-6">

        {{-- Judul Halaman --}}
        <div class="bg-white shadow rounded-lg p-4">
            <h2 class="text-lg font-semibold text-gray-800">Pengaturan Akun</h2>
            <p class="text-sm text-gray-500">Kelola informasi akun Anda dengan aman</p>
        </div>

        {{-- Notifikasi --}}
        @if (session('status'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded shadow">
                {{ session('status') }}
            </div>
        @endif

        {{-- ✅ FOTO PROFIL --}}
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-md font-semibold text-gray-700 mb-4">Foto Profil</h3>
            <form action="{{ route('profile.update.photo') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')

                <div class="flex items-center gap-4 mb-4">
                    @if (auth()->user()->foto)
                        <img src="{{ asset('storage/foto/' . auth()->user()->foto) }}"
                             class="w-16 h-16 rounded-full object-cover shadow"
                             alt="Foto Profil">
                    @else
                        <div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 text-xl">
                            ?
                        </div>
                    @endif

                    <input type="file" name="foto" accept="image/*" class="text-sm">
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        Update Foto
                    </button>
                </div>
            </form>
        </div>

        {{-- ✅ EDIT PROFIL --}}
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-md font-semibold text-gray-700 mb-4">Edit Profil</h3>
            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <label class="block text-sm text-gray-700 mb-1">Nama</label>
                    <input type="text" name="name" value="{{ auth()->user()->name }}"
                           class="w-full border border-gray-300 rounded px-3 py-2 text-sm" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm text-gray-700 mb-1">Email</label>
                    <input type="email" name="email" value="{{ auth()->user()->email }}"
                           class="w-full border border-gray-300 rounded px-3 py-2 text-sm" required>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>

        {{-- ✅ UBAH PASSWORD --}}
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-md font-semibold text-gray-700 mb-4">Ubah Password</h3>
            <form action="{{ route('profile.update.password') }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <label class="block text-sm text-gray-700 mb-1">Password Lama</label>
                    <input type="password" name="password_lama"
                           class="w-full border border-gray-300 rounded px-3 py-2 text-sm" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm text-gray-700 mb-1">Password Baru</label>
                    <input type="password" name="password_baru"
                           class="w-full border border-gray-300 rounded px-3 py-2 text-sm" required>
                </div>

                <div class="mb-4">
                    <label class="block text-sm text-gray-700 mb-1">Konfirmasi Password Baru</label>
                    <input type="password" name="password_baru_confirmation"
                           class="w-full border border-gray-300 rounded px-3 py-2 text-sm" required>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                            class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded">
                        Ubah Password
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection
