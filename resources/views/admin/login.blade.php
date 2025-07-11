<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin | E-Audit Systems</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-slate-100 via-white to-slate-200 min-h-screen flex flex-col justify-center items-center font-sans">

    <!-- Card Login -->
    <div class="bg-white shadow-xl rounded-xl w-full max-w-sm border border-gray-200 overflow-hidden">
        
        <!-- Header EA Systems + Login Admin -->
        <div class="bg-gradient-to-r from-purple-600 to-indigo-400 px-6 pt-5 pb-5 rounded-t-xl shadow text-center text-white">
            <h1 class="text-2xl font-extrabold">EA Systems</h1>
            <p class="text-sm font-medium opacity-85 mt-1">Login Admin</p>
        </div>

        <!-- Form Login -->
        <div class="p-6 pt-2">
            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded text-sm mb-4 text-center">
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login.post') }}" class="space-y-4">
                @csrf

                <!-- Input Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" required autofocus
                           class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none shadow-sm text-sm">
                </div>

                <!-- Input Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <input type="password" id="password" name="password" required
                           class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-indigo-500 focus:outline-none shadow-sm text-sm">
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between text-sm">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="mr-2 rounded border-gray-300 text-indigo-600">
                        <span class="text-gray-600">Ingat saya</span>
                    </label>
                    <a href="#" class="text-indigo-600 hover:underline">Lupa password?</a>
                </div>

                <!-- Tombol Submit -->
                <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-medium py-2 px-4 rounded-md transition duration-200 text-sm shadow">
                    Masuk
                </button>
            </form>

            <!-- Kembali ke login user biasa -->
            <div class="mt-4 text-center">
                <span class="text-sm text-gray-600">Bukan admin?</span>
                <a href="{{ route('login') }}" class="text-indigo-600 hover:underline font-medium text-sm">Masuk sebagai Auditor</a>
            </div>
        </div>
    </div>

    <!-- Versi & Status di bawah card -->
    <div class="mt-3 text-center text-sm text-gray-500">
        <p>Versi: <span class="font-medium">1.0.0</span></p>
        <p>Status: <span class="font-medium text-green-600">Admin Aktif</span></p>
    </div>

</body>
</html>
