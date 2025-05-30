<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-poppins bg-gray-100 m-0 p-0">
    <div class="max-w-md mx-auto mt-12 p-6 bg-white rounded-lg shadow-md">
        <!-- Back Link -->
        <a href="/" class="block text-sm text-gray-700 hover:underline mb-4"><img src="{{ asset('assets/images/icons/back.svg') }}" alt=""></a>

        <!-- Title -->
        <h1 class="text-center text-2xl font-semibold text-gray-800 mb-6">Login</h1>

        <!-- Form -->
        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf

            <!-- Email Input -->
            <input type="email" name="email" placeholder="Email" required
                class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700">

            <!-- Password Input -->
            <input type="password" name="password" placeholder="Password" required
                class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700">

            <!-- Submit Button -->
            <button type="submit"
                class="w-full p-3 bg-purple-400 text-black rounded-md font-medium text-lg hover:bg-purple-600">
                Login
            </button>
        </form>

        <!-- Register Link -->
        <a href="{{ route('register') }}" class="block text-center mt-3 text-gray-800 text-sm hover:underline">
            Belum punya akun? Daftar di sini
        </a>
    </div>

    <!-- Tailwind Font Customization -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap');

        .font-poppins {
            font-family: 'Poppins', sans-serif;
        }
    </style>
</body>

</html>
