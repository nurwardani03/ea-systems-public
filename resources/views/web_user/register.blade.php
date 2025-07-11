<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun Auditor | E-Audit Systems</title>
    <script src="https://cdn.tailwindcss.com"></script> 
    <link rel="icon" href="{{ asset('images/logo_psi.png') }}" type="image/png">
</head>
<body class="bg-gradient-to-br from-slate-100 via-white to-slate-200 min-h-screen flex items-center justify-center font-sans">

    <div class="bg-white shadow-xl rounded-xl w-full max-w-md border border-gray-200 overflow-hidden">

<!-- Header EA Systems + Judul -->
<div class="bg-gradient-to-r from-blue-500 to-blue-300 px-6 pt-5 pb-5 rounded-t-xl shadow text-center text-white">
    <h1 class="text-2xl font-extrabold">EA Systems</h1>
    <p class="text-sm font-medium opacity-85 mt-1">Daftar Akun Auditor</p>
</div>

        <!-- Form Registrasi -->
        <div class="p-6">
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded text-sm mb-4 text-center">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register.post') }}" class="space-y-4">
                @csrf

                <!-- Nama -->
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                    <input type="text" id="name" name="name" required
                           class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 text-sm">
                </div>

                <!-- Bagian (dari DB) -->
                <div>
                    <label for="bagian_id" class="block text-sm font-medium text-gray-700">Bagian</label>
                    <select id="bagian_id" name="bagian_id" required
                            class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 text-sm">
                        <option value="">-- Pilih Bagian --</option>
                        @foreach ($bagians as $bagian)
                            <option value="{{ $bagian->id }}">{{ $bagian->nama_bagian }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" required
                           class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 text-sm">
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" required
                           class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 text-sm">
                </div>

                <!-- Konfirmasi Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                           class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-2 focus:ring-blue-500 text-sm">
                </div>

                <!-- Tombol Submit -->
                <button type="submit"
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md transition duration-200 text-sm shadow">
                    Daftar
                </button>

                <div class="text-center text-sm text-gray-600 mt-2">
                    Sudah punya akun?
                    <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-medium">Login di sini</a>
                </div>
            </form>
        </div>
    </div>

</body>
</html>
