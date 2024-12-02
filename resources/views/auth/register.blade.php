<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-poppins bg-gray-100">
    <div class="max-w-md mx-auto mt-12 p-6 bg-white rounded-lg shadow-md">
        <a href="/" class="block text-sm text-gray-700 hover:underline mb-4"><img src="{{ asset('assets/images/icons/back.svg') }}" alt=""></a>
        <!-- Title -->
        <h1 class="text-center text-2xl font-semibold text-gray-800 mb-6">Register</h1>

        <!-- Form -->
        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf
            <!-- Name Input -->
            <input type="text" name="name" placeholder="Nama" required
                class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700">

            <!-- Email Input -->
            <input type="email" name="email" placeholder="Email" required
                class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700">

            <!-- Password Input -->
            <input type="password" name="password" placeholder="Password" required
                class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700">

            <!-- Password Confirmation Input -->
            <input type="password" name="password_confirmation" placeholder="Konfirmasi Password" required
                class="w-full p-3 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700">

            <!-- Submit Button -->
            <button type="submit"
                class="w-full p-3 bg-purple-400 text-black rounded-md font-medium text-lg hover:bg-yellow-300">
                Register
            </button>
        </form>

        <!-- Login Link -->
        <a href="{{ route('login') }}" class="block text-center mt-4 text-sm text-gray-800 hover:underline">
            Sudah punya akun? Login di sini
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
