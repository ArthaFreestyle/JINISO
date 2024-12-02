<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link href="{{ asset('output.css') }}" rel="stylesheet">
</head>
<body>
    <div class="flex justify-center items-center min-h-screen bg-gray-100">
        <div class="w-full max-w-md bg-white p-6 rounded-lg shadow-md">
            <h2 class="text-2xl font-bold mb-4 text-center">Welcome, {{ Auth::user()->name }}</h2>
            <p class="text-lg mb-4">Email: {{ Auth::user()->email }}</p>

            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="w-full py-2 bg-red-500 text-white rounded-md">Logout</button>
            </form>
        </div>
    </div>
</body>
</html>
