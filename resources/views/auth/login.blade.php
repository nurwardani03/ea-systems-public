<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Auditor</title>
    <!-- CDN Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-blue-100 via-blue-200 to-blue-300 min-h-screen flex items-center justify-center">

    <div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-md">
        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <img src="{{ asset('images/logo_psi.png') }}" alt="Logo PT" class="h-16">
        </div>

        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">Login Auditor</h2>

        @if(session('error'))
            <div class="bg-red-100 text-red-600 p-3 rounded mb-4 text-sm text-center">
                {{ session('error') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <label for="username" class="block text-sm font-medium text-gray-700">Username</label>
                <input type="text" id="username" name="username" required
                       class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" required
                       class="w-full mt-1 px-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-blue-400">
            </div>

            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="mr-2">
                    <span class="text-gray-600">Ingat saya</span>
                </label>
                <a href="#" class="text-blue-600 hover:underline">Lupa password?</a>
            </div>

            <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded-md transition duration-200">
                Masuk
            </button>
        </form>
    </div>

</body>
</html>
